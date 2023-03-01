<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Mails;

use App\Containers\AppSection\Admin\Actions\FindClientHelpAction;
use App\Containers\AppSection\Admin\Data\Transporters\FindClientHelpTransporter;
use App\Containers\AppSection\Client\Data\Enums\ClientHelpPagesEnum;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Mails\MailMessage;
use App\Ship\Parents\Mails\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\HtmlString;

class CreatePasswordEmail extends Mail
{
    use Queueable;

    public function __construct(protected User $recipient, protected string $email, protected string $resetUrl)
    {
    }

    public function build(): self
    {
        $token = Password::createToken($this->recipient);
        $url   = config('app.frontend_url') . sprintf('/%s?email=%s&token=%s', $this->resetUrl, rawurlencode($this->email), $token);
        $name  = $this->recipient->first_name . ' ' . $this->recipient->last_name;
        $style = 'margin: 30px 0 30px 0; word-break: break-word; padding: 35px 45px 35px 45px; background: #073763; border-radius: 5px; display: inline-block; height:auto; max-width:380px;';

        $videoTutorialObject = app(FindClientHelpAction::class)->run(new FindClientHelpTransporter(
            ['type' => ClientHelpPagesEnum::PROSPECT_EMAIL_HELP]
        ));

        $videoTutorialUrl = ($videoTutorialObject->media) ? $videoTutorialObject->media->getTemporaryUrl(now()->addDays(5)) : '';

        $view = (new MailMessage())
            ->greeting(sprintf('Hello %s! Welcome to IRIS, your secure Strategic Wealth Designers portal!', $name))
            ->line('With IRIS you will be able to securely upload any financial statements and household information, as well as get in touch with your SWD team.')
            ->line('To get started, please click the activation link below and create a password.')
            ->plate('Your login ID will be:', new HtmlString(sprintf("<p style='margin: 10px; font-weight: 600;'>%s</p>", $this->recipient->email)))
            ->button('Click here for your IRIS tutorial video!', $videoTutorialUrl, true, $style)
            ->button('Create IRIS Account here', $url, true)
            ->render();

        return $this->html($view)
            ->subject('Welcome')
            ->to($this->recipient->email, $name);
    }
}

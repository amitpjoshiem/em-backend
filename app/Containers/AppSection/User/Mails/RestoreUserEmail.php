<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Mails;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Mails\MailMessage;
use App\Ship\Parents\Mails\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\HtmlString;

class RestoreUserEmail extends Mail
{
    use Queueable;

    public function __construct(protected User $recipient, protected string $email, protected string $resetUrl)
    {
    }

    public function build(): self
    {
        $token = Password::createToken($this->recipient);
        $url   = config('app.frontend_url') . sprintf('/%s?email=%s&token=%s', $this->resetUrl, rawurlencode($this->email), $token);

        $name = $this->recipient->first_name . ' ' . $this->recipient->last_name;

        $view = (new MailMessage())
            ->greeting(sprintf('Hello %s! Welcome to IRIS, your secure Strategic Wealth Designers portal!', $name))
            ->line('With IRIS you will be able to securely upload any financial statements and household information, as well as get in touch with your SWD team.')
            ->line('To get started, please reset password by the link below')
            ->plate('Your login ID will be:', new HtmlString(sprintf("<p style='margin: 10px; font-weight: 600;'>%s</p>", $this->recipient->email)))
            ->button('Reset Password', $url)
            ->render();

        return $this->html($view)
            ->subject('Reactivate')
            ->to($this->recipient->email, $name);
    }
}

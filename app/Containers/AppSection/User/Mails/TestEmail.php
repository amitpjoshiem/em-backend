<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Mails;

use App\Ship\Mails\MailMessage;
use App\Ship\Parents\Mails\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;

class TestEmail extends Mail
{
    use Queueable;

    public function __construct(protected string $email)
    {
    }

    public function build(): self
    {
        $view = (new MailMessage())
            ->greeting('Hello! Welcome to IRIS, your secure Strategic Wealth Designers portal!')
            ->line('With IRIS you will be able to securely upload any financial statements and household information, as well as get in touch with your SWD team.')
            ->line('To get started, please reset password by the link below')
            ->button('Test', config('app.url') . '?' . rawurlencode('test+23@gmail.com'))
            ->plate('Your login ID will be:', new HtmlString(sprintf("<p style='margin: 10px; font-weight: 600;'>%s</p>", $this->email)))
            ->render();

        return $this->html($view)
            ->subject('Test Email')
            ->to($this->email, 'Test Test');
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Mails;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Mails\MailMessage;
use App\Ship\Parents\Mails\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Password;

class UserForgotPasswordMail extends Mail implements ShouldQueue
{
    use Queueable;

    public function __construct(protected User $recipient, protected string $resetUrl)
    {
    }

    public function build(): self
    {
        $token = Password::createToken($this->recipient);
        $url   = config('app.frontend_url') . sprintf('/%s?email=%s&token=%s', $this->resetUrl, rawurlencode($this->recipient->email), $token);

        $view = (new MailMessage())
            ->greeting(sprintf('Hello %s', $this->recipient->getName()))
            ->line('If you requested this password reset then click the link below.')
            ->button('Reset Password', $url)
            ->line('If you did not request a password reset, you can safely ignore this email. Only a person with access to your email can reset your account password.')
            ->render();

        return $this->html($view)
            ->subject('Reset Password')
            ->to($this->recipient->email, $this->recipient->first_name);
    }
}

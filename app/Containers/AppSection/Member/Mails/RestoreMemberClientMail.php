<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Mails;

use App\Ship\Mails\MailMessage;
use App\Ship\Parents\Mails\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class RestoreMemberClientMail extends Mail implements ShouldQueue
{
    use Queueable;

    public function __construct(protected string $email)
    {
    }

    public function build(): self
    {
        $view = (new MailMessage())
            ->line('Welcome back to Client Portal of SWDIRIS.')
            ->line('Thank you for becoming our client. We have restored the access for you, so you can use the Client Portal to see your investment details.')
            ->button('Login', config('app.frontend_url'))
            ->render();

        return $this->subject('Restore SWDIRIS')->html($view)
            ->to($this->email);
    }
}

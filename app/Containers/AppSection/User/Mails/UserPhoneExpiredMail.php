<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Mails;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Mails\MailMessage;
use App\Ship\Parents\Mails\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserPhoneExpiredMail extends Mail implements ShouldQueue
{
    use Queueable;

    public function __construct(protected User $recipient)
    {
    }

    public function build(): self
    {
        $view = (new MailMessage())
            ->greeting(sprintf('Hello %s', $this->recipient->getName()))
            ->line('Your phone verification expired. You need to verify your phone.')
            ->line('If You use phone as OTP your OTP service restored to email.')
            ->render();

        return $this->html($view)
            ->to($this->recipient->email, $this->recipient->first_name);
    }
}

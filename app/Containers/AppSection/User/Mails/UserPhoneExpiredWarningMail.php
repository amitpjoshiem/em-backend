<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Mails;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Mails\MailMessage;
use App\Ship\Parents\Mails\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserPhoneExpiredWarningMail extends Mail implements ShouldQueue
{
    use Queueable;

    public function __construct(protected User $recipient)
    {
    }

    public function build(): self
    {
        $expireDays = config('appSection-user.phone_expire_days');
        $expireDate = $this->recipient->phone_verified_at?->addDays($expireDays);
        $view       = (new MailMessage())
            ->greeting(sprintf('Hello %s', $this->recipient->getName()))
            ->line(sprintf('Your phone verification expired at %s.', (string)$expireDate?->toDateString()))
            ->line('Please verify your phone.')
            ->render();

        return $this->html($view)
            ->to($this->recipient->email, $this->recipient->first_name);
    }
}

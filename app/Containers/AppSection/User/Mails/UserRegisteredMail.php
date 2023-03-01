<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Mails;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Mails\MailMessage;
use App\Ship\Parents\Mails\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Lang;

class UserRegisteredMail extends Mail implements ShouldQueue
{
    use Queueable;

    public function __construct(protected User $user)
    {
    }

    public function build(): self
    {
        $view = (new MailMessage())
            ->greeting(sprintf('Welcome %s!', $this->user->username))
            ->subject(Lang::get('Welcome'))
            ->line(Lang::get('Thank you for signing up.'))
            ->render();

        return $this->html($view)->to(
            $this->user->email,
            $this->user->username
        );
    }
}

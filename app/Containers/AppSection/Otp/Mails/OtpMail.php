<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Mails;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Mails\MailMessage;
use App\Ship\Parents\Mails\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Lang;

class OtpMail extends Mail implements ShouldQueue
{
    use Queueable;

    public function __construct(protected string $code, protected int $userId)
    {
    }

    /**
     * @throws NotFoundException
     */
    public function build(): self
    {
        /** @var User $user */
        $user = app(FindUserByIdTask::class)->run($this->userId);

        $view = (new MailMessage())
            ->line(Lang::get('Here is your verification Code from IRIS. Please enter this code'))
            ->code($this->code)
            ->render();

        return $this->subject('OTP Code')->html($view)->to(
            $user->email,
            $user->username
        )->onQueue('email');
    }
}

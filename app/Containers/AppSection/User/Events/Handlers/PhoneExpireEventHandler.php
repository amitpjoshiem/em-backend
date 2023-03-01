<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Events\Handlers;

use App\Containers\AppSection\Otp\Services\EmailOtpService;
use App\Containers\AppSection\Otp\Tasks\ChangeUserOtpSecretTask;
use App\Containers\AppSection\User\Events\Events\PhoneExpiredEvent;
use App\Containers\AppSection\User\Mails\UserPhoneExpiredMail;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class PhoneExpireEventHandler implements ShouldQueue
{
    public function handle(PhoneExpiredEvent $event): void
    {
        /** @var User $user */
        $user = app(FindUserByIdTask::class)->run($event->userId);
        app(UpdateUserTask::class)->run([
            'phone_verified_at' => null,
        ], $user->getKey());
        app(ChangeUserOtpSecretTask::class)->run($user->getKey(), new EmailOtpService());
        Mail::send((new UserPhoneExpiredMail($user))->onQueue('email'));
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Events\Handlers;

use App\Containers\AppSection\User\Events\Events\PhoneExpiredWarningEvent;
use App\Containers\AppSection\User\Mails\UserPhoneExpiredWarningMail;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class PhoneExpireWarningEventHandler implements ShouldQueue
{
    public function handle(PhoneExpiredWarningEvent $event): void
    {
        /** @var User $user */
        $user = app(FindUserByIdTask::class)->run($event->userId);
        Mail::send((new UserPhoneExpiredWarningMail($user))->onQueue('email'));
    }
}

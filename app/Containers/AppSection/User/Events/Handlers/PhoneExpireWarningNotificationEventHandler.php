<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Events\Handlers;

use App\Containers\AppSection\Notification\Events\Events\PhoneWarningNotificationEvent;
use App\Containers\AppSection\Notification\Tasks\GetChannelNameByUserTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use Illuminate\Contracts\Queue\ShouldQueue;
use LaravelCentrifugo\Events\SubscribeEvent;

class PhoneExpireWarningNotificationEventHandler implements ShouldQueue
{
    public function handle(SubscribeEvent $event): void
    {
        /** @var User $user */
        $user                = app(FindUserByIdTask::class)->run($event->userId);
        $notificationChannel = app(GetChannelNameByUserTask::class)->run($user);

        if ($user->phone_verified_at === null) {
            return;
        }

        if ($event->channel === $notificationChannel) {
            $verifiedAt  = $user->phone_verified_at->toImmutable();
            $expireDays  = config('appSection-user.phone_expire_days');
            $warningDays = config('appSection-user.phone_expire_warning_days');
            $expireDate  = $verifiedAt->addDays($expireDays);

            $warningDate   = $expireDate->subDays($warningDays);

            if (now()->diff($warningDate)->invert === 1) {
                event(new PhoneWarningNotificationEvent($user->getKey(), $expireDate->format('Y-m-d')));
            }
        }
    }
}

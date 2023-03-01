<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\SubActions;

use App\Containers\AppSection\User\Events\Events\PhoneExpiredEvent;
use App\Containers\AppSection\User\Events\Events\PhoneExpiredWarningEvent;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Tasks\Task;

class CheckUserPhoneExpireSubAction extends Task
{
    public function run(User $user): void
    {
        if ($user->phone === null || $user->phone_verified_at === null) {
            return;
        }

        $verifiedAt  = $user->phone_verified_at->toImmutable();
        $expireDays  = config('appSection-user.phone_expire_days');
        $warningDays = config('appSection-user.phone_expire_warning_days');
        $expireDate  = $verifiedAt->addDays($expireDays);

        if ($expireDate->diff(now())->invert === 0) {
            event(new PhoneExpiredEvent($user->getKey()));

            return;
        }

        $warningDate   = $expireDate->subDays($warningDays);

        if (now()->diff($warningDate)->invert === 1) {
            event(new PhoneExpiredWarningEvent($user->getKey()));
        }
    }
}

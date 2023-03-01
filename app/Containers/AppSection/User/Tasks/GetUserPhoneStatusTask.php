<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Ship\Parents\Tasks\Task;
use Carbon\CarbonImmutable;

class GetUserPhoneStatusTask extends Task
{
    /**
     * @var string
     */
    public const VERIFIED = 'verified';

    /**
     * @var string
     */
    public const WARNING = 'warning';

    /**
     * @var string
     */
    public const EXPIRED = 'expired';

    public function run(CarbonImmutable | null $phoneVerifiedAt): string
    {
        if ($phoneVerifiedAt === null) {
            return self::EXPIRED;
        }

        $expireDays  = config('appSection-user.phone_expire_days');
        $warningDays = config('appSection-user.phone_expire_warning_days');
        $expiredAt   = $phoneVerifiedAt->addDays($expireDays);

        if ($expiredAt->diff(now())->invert === 0) {
            return self::EXPIRED;
        }

        $warningAt = $expiredAt->subDays($warningDays);

        if ($warningAt->diff(now())->invert === 0) {
            return self::WARNING;
        }

        return self::VERIFIED;
    }
}

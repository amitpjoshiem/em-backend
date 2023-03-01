<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Actions;

use App\Containers\AppSection\Otp\Data\Repositories\OtpRepository;
use App\Containers\AppSection\Otp\Models\Otp;
use App\Containers\AppSection\Otp\Services\OtpService;
use App\Containers\AppSection\Otp\Tasks\FindOtpByCondition;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Cache;

class CheckUserOtpAction extends Action
{
    public function __construct(protected OtpRepository $otpRepository)
    {
    }

    public function run(User $user, string $tokenId): ?Otp
    {
        $totp = Cache::get(OtpService::getCacheKey($user->id, $tokenId));

        if ($totp === null) {
            return null;
        }

        /** @var Otp | null $otp */
        return app(FindOtpByCondition::class)->run([
            'user_id' => $user->getKey(),
            'revoked' => false,
        ]);
    }
}

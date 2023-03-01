<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Tasks;

use App\Containers\AppSection\Otp\Data\Repositories\OtpRepository;
use App\Containers\AppSection\Otp\Models\Otp;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Tasks\Task;

class CheckUserOtpVerifyTask extends Task
{
    public function __construct(protected OtpRepository $otpRepository)
    {
    }

    public function run(User $user): bool
    {
        $token = $user->token();
        /** @var Otp | null  $otp */
        $otp = $this->otpRepository->findWhere([
            $user->getForeignKey()  => $user->getKey(),
            'oauth_access_token_id' => $token?->getKey(),
            'revoked'               => false,
            ['expires_at', '<', 'now()'],
        ])->first();

        return $otp !== null;
    }
}

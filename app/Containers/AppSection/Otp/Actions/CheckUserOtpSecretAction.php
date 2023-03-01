<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Actions;

use App\Containers\AppSection\Otp\Data\Repositories\OtpSecurityRepository;
use App\Containers\AppSection\Otp\Models\OtpSecurity;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;

class CheckUserOtpSecretAction extends Action
{
    public function __construct(protected OtpSecurityRepository $otpSecurityRepository)
    {
    }

    public function run(User $user): ?OtpSecurity
    {
        return $this->otpSecurityRepository->findByField('user_id', $user->id)->first();
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Actions;

use App\Containers\AppSection\Otp\Data\Repositories\OtpRepository;
use App\Ship\Parents\Actions\Action;

class RevokeOtpTokenAction extends Action
{
    public function __construct(protected OtpRepository $otpRepository)
    {
    }

    public function run(string $uuid): bool
    {
        return $this->otpRepository->revokeOtpTokenByUuid($uuid);
    }
}

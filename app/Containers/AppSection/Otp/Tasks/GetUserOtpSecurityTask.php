<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Tasks;

use App\Containers\AppSection\Otp\Data\Repositories\OtpSecurityRepository;
use App\Containers\AppSection\Otp\Models\OtpSecurity;
use App\Ship\Parents\Tasks\Task;

class GetUserOtpSecurityTask extends Task
{
    public function __construct(protected OtpSecurityRepository $otpSecurityRepository)
    {
    }

    public function run(int $userId): ?OtpSecurity
    {
        return $this->otpSecurityRepository->findByField('user_id', $userId)->first();
    }
}

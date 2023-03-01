<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Tasks;

use App\Containers\AppSection\Otp\Data\Repositories\OtpRepository;
use App\Containers\AppSection\Otp\Models\Otp;
use App\Ship\Parents\Tasks\Task;

class FindOtpByCondition extends Task
{
    public function __construct(protected OtpRepository $otpRepository)
    {
    }

    public function run(array $condition): ?Otp
    {
        return $this->otpRepository->findWhere($condition)->first();
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Tasks;

use App\Containers\AppSection\Otp\Data\Repositories\OtpRepository;
use App\Containers\AppSection\Otp\Models\Otp;
use App\Ship\Parents\Tasks\Task;

class GetOtpByUuidTask extends Task
{
    public function __construct(protected OtpRepository $otpRepository)
    {
    }

    public function run(string $uuid): ?Otp
    {
        return $this->otpRepository->findByField('external_token', $uuid)->first();
    }
}

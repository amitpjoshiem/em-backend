<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Tasks;

use App\Containers\AppSection\Otp\Data\Repositories\OtpRepository;
use App\Containers\AppSection\Otp\Models\Otp;
use App\Ship\Parents\Tasks\Task;

class GetUserValidOtpTokenTask extends Task
{
    public function __construct(protected OtpRepository $otpRepository)
    {
    }

    public function run(int $userId): ?Otp
    {
        return $this->otpRepository
            ->findWhere([
                'user_id'   => $userId,
                'revoked'   => false,
            ])
            ->where('expires_at', '<', 'now()')
            ->first();
    }
}

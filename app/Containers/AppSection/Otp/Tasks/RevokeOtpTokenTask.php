<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Tasks;

use App\Containers\AppSection\Otp\Data\Repositories\OtpRepository;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class RevokeOtpTokenTask extends Task
{
    public function __construct(protected OtpRepository $otpRepository)
    {
    }

    /**
     * @throws ValidatorException
     */
    public function run(int $id): void
    {
        $this->otpRepository->update([
            'revoked' => true,
        ], $id);
    }
}

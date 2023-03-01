<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Tasks;

use App\Containers\AppSection\Otp\Data\Repositories\OtpSecurityRepository;
use App\Containers\AppSection\Otp\Models\OtpSecurity;
use App\Containers\AppSection\Otp\Services\OtpService;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class ChangeUserOtpEnabledTask extends Task
{
    public function __construct(protected OtpSecurityRepository $repository)
    {
    }

    /**
     * @throws UpdateResourceFailedException
     * @throws ValidatorException
     */
    public function run(int $userId, OtpService $service): void
    {
        /** @var OtpSecurity $otpSecurity */
        $otpSecurity = $this->repository->findByField('user_id', $userId)->first();

        try {
            $this->repository->update([
                'service_type' => $service->getClassName(),
            ], $otpSecurity->id);
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }
}

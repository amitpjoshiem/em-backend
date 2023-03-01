<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Actions;

use App\Containers\AppSection\Otp\Data\Repositories\OtpSecurityRepository;
use App\Containers\AppSection\Otp\Models\OtpSecurity;
use App\Containers\AppSection\Otp\Services\OtpService;
use App\Containers\AppSection\Otp\Services\OtpServiceInterface;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action;
use Exception;
use Prettus\Validator\Exceptions\ValidatorException;

class CreateUserOtpSecretAction extends Action
{
    public function __construct(protected OtpSecurityRepository $otpSecurityRepository)
    {
    }

    /**
     * @throws CreateResourceFailedException
     * @throws ValidatorException
     */
    public function run(int $userId): OtpSecurity
    {
        /** @psalm-var class-string<OtpServiceInterface> $defaultService */
        $defaultService = config('appSection-otp.default_service_type');
        /** @var OtpService $service */
        $service = new $defaultService();

        try {
            return $this->otpSecurityRepository->create([
                'user_id'       => $userId,
                'secret'        => $service->getSecret($userId),
                'service_type'  => $service->getClassName(),
            ]);
        } catch (Exception $exception) {
            throw (new CreateResourceFailedException(previous: $exception))->debug($exception);
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Events\Handlers;

use App\Containers\AppSection\Authentication\Events\ApiLoginEvent;
use App\Containers\AppSection\Otp\Actions\CheckUserOtpAction;
use App\Containers\AppSection\Otp\Actions\CheckUserOtpSecretAction;
use App\Containers\AppSection\Otp\Actions\CreateUserOtpSecretAction;
use App\Containers\AppSection\Otp\Models\Otp;
use App\Containers\AppSection\Otp\Models\OtpSecurity;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Prettus\Validator\Exceptions\ValidatorException;

class CheckOtpEventHandler implements ShouldQueue
{
    public ?string $queue = 'auth';

    /**
     * @throws CreateResourceFailedException
     * @throws ValidatorException|NotFoundException
     */
    public function handle(ApiLoginEvent $event): void
    {
        if (!config('auth.otp')) {
            return;
        }

        /** @var User $user */
        $user = app(FindUserByIdTask::class)->run($event->userId);

        /** @var OtpSecurity | null $secret */
        $secret = app(CheckUserOtpSecretAction::class)->run($user);

        if ($secret === null) {
            $secret = app(CreateUserOtpSecretAction::class)->run($user->id);
        }

        if (!$secret->enabled) {
            return;
        }

        /** @var Otp | null  $otp */
        $otp = app(CheckUserOtpAction::class)->run($user, $event->tokenId);

        if ($otp === null || $otp->isOtpExpired() || $otp->isOtpRevoked()) {
            $secret->otpService->resolveOtp($user, $event->tokenId);
        }
    }
}

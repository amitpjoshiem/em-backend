<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Actions;

use App\Containers\AppSection\Authentication\Events\ApiLoginEvent;
use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Otp\Exceptions\OtpAlreadySentException;
use App\Containers\AppSection\Otp\Models\OtpSecurity;
use App\Containers\AppSection\Otp\Tasks\GetUserOtpSecurityTask;
use App\Containers\AppSection\Otp\Tasks\RevokeAllOldUserOtpTokensTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;
use Laravel\Passport\Token;

class ReSendOtpAction extends Action
{
    public function run(): void
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        /** @var Token $token */
        $token = $user->token();

        /** @var OtpSecurity $otpSecurity */
        $otpSecurity = app(GetUserOtpSecurityTask::class)->run($user->getKey());

        if (!\in_array($otpSecurity->otpService::class, config('appSection-otp.resend_otp_services'), true)) {
            return;
        }

        if (!$otpSecurity->otpService->needToResendOTP($user->getKey())) {
            throw new OtpAlreadySentException();
        }

        app(RevokeAllOldUserOtpTokensTask::class)->filterByUser($user->getKey())->run();

        event(new ApiLoginEvent($user->getKey(), $token->getKey()));
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Services;

use App\Containers\AppSection\Authentication\Tasks\GetAuthenticatedUserTask;
use App\Containers\AppSection\Otp\Exceptions\OtpVerifyException;
use App\Containers\AppSection\Otp\Models\OtpSecurity;
use App\Containers\AppSection\Otp\Tasks\GetUserOtpSecurityTask;
use App\Containers\AppSection\User\Models\User;
use OTPHP\TOTP;

class GoogleOtpService extends OtpService
{
    public function resolveOtp(User $user, string $tokenId): void
    {
    }

    public function checkOtp(User $user, ?string $code): bool
    {
        if ($code === null) {
            return false;
        }

        /** @var OtpSecurity $otpSecurity */
        $otpSecurity = app(GetUserOtpSecurityTask::class)->run($user->getKey());

        $otp = TOTP::create($otpSecurity->secret);

        return $otp->verify($code);
    }

    public static function generateQrCode(): array
    {
        /** @var User $user */
        $user = app(GetAuthenticatedUserTask::class)->run();
        /** @var OtpSecurity $otpSecurity */
        $otpSecurity = app(GetUserOtpSecurityTask::class)->run($user->getKey());

        return [
            'code'   => $otpSecurity->secret,
            'data'   => sprintf('otpauth://totp/%s?secret=%s&issuer=%s', 'SWD:' . $user->email, $otpSecurity->secret, 'SWD'),
        ];
    }

    /**
     * @throws OtpVerifyException
     */
    public function changeOtp(User $user, ?string $code): void
    {
        if ($code === null || !$this->checkOtp($user, $code)) {
            throw new OtpVerifyException();
        }
    }
}

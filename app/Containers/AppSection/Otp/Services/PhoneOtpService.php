<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Services;

use App\Containers\AppSection\Otp\Exceptions\OtpAlreadySentException;
use App\Containers\AppSection\Otp\Exceptions\OtpChangeException;
use App\Containers\AppSection\Otp\Tasks\GetUserValidTokenTask;
use App\Containers\AppSection\Sms\Actions\SendSmsSubAction;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\Cache;
use Laravel\Passport\Token;

class PhoneOtpService extends OtpService
{
    /**
     * @throws OtpAlreadySentException
     */
    public function resolveOtp(User $user, string $tokenId): void
    {
        if (!$this->needToResendOTP($user->getKey())) {
            throw new OtpAlreadySentException();
        }

        $code = $this->generateCode();
        Cache::add(self::getCacheKey($user->id, $tokenId), $code, $this->getCodeTtl());
        app(SendSmsSubAction::class)->run($user->getKey(), sprintf('Your OTP Code: %s', $code));
        Cache::add($this->getOptSentKey($user->getKey()), true, config('appSection-otp.resend_otp_ttl'));
    }

    public function checkOtp(User $user, string $code): bool
    {
        /** @FIXME Develop code verify 000000 */
        if (config('app.is_development') && $code === config('appSection-otp.dev_verify_code')) {
            return true;
        }

        /** @var Token $token */
        $token      = app(GetUserValidTokenTask::class)->run($user->getKey());
        $tokenId    = $token->getKey();
        $cachedCode = Cache::get(self::getCacheKey($user->id, $tokenId));
        $compare    = $code === $cachedCode;

        if ($compare) {
            Cache::forget(self::getCacheKey($user->id, $tokenId));
        }

        return $compare;
    }

    public function changeOtp(User $user, ?string $code): void
    {
        if ($user->phone_verified_at === null) {
            throw new OtpChangeException();
        }
    }
}

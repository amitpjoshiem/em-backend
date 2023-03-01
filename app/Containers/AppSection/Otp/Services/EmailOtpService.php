<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Services;

use App\Containers\AppSection\Otp\Exceptions\OtpAlreadySentException;
use App\Containers\AppSection\Otp\Mails\OtpMail;
use App\Containers\AppSection\Otp\Tasks\GetUserValidTokenTask;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\Token;

class EmailOtpService extends OtpService
{
    public function resolveOtp(User $user, string $tokenId): void
    {
        if (!$this->needToResendOTP($user->getKey())) {
            /** @FIXME change to return after fix */
            throw new OtpAlreadySentException();
        }

        $code = $this->generateCode();
        Cache::put(self::getCacheKey($user->id, $tokenId), $code, $this->getCodeTtl());
        Mail::send((new OtpMail($code, $user->id))->onQueue('email'));
        Cache::put($this->getOptSentKey($user->getKey()), true, config('appSection-otp.resend_otp_ttl'));
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
        /**
         * For EMail OTP Service don`t need to verify the code.
         */
    }
}

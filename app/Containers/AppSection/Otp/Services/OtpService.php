<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Services;

use Base32\Base32;
use Hashids;
use Illuminate\Support\Facades\Cache;

abstract class OtpService implements OtpServiceInterface
{
    /**
     * @var string
     */
    private const OTP_SENT_KEY = 'otp:sent:%s';

    final public function __construct()
    {
    }

    protected function getCodeTtl(): int
    {
        return config('appSection-otp.totp_ttl');
    }

    protected function generateCode(): string
    {
        $code   = '';
        $length = config('appSection-otp.number_of_digits');

        /** @noRector \Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector */
        for ($i = 0; $i < $length; $i++) {
            $code .= random_int(0, 9);
        }

        return $code;
    }

    public function getSecret(int $userId): string
    {
        return str_replace('=', '', Base32::encode(config('app.name') . Hashids::encode($userId)));
    }

    public function getClassName(): string
    {
        return static::class;
    }

    public static function getCacheKey(int $userId, string $tokenId): string
    {
        return sprintf('%s:%s', $userId, $tokenId);
    }

    protected function getOptSentKey(int $userId): string
    {
        return sprintf(self::OTP_SENT_KEY, $userId);
    }

    public function needToResendOTP(int $userId): bool
    {
        return !Cache::has($this->getOptSentKey($userId));
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\Events\Events;

use Faker\Generator;

class ChangeOTPServiceEvent extends AbstractActivityEvent
{
    public function __construct(int $userId, string $otpService)
    {
        parent::__construct($userId, ['service' => $otpService]);
    }

    public static function getActivityHtmlString(array $data): string
    {
        return sprintf('<p>2FA changed to %s OTP Verification</p>', ucfirst($data['service']));
    }

    public static function seedActivity(Generator $faker, int $userId): array
    {
        $otpsTypes = array_keys(config('appSection-otp.otp_services'));

        return [
            'service' => $faker->randomElement($otpsTypes),
        ];
    }
}

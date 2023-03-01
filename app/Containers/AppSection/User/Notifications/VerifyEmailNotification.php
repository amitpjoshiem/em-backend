<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Notifications;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Notifications\VerifyEmail;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class VerifyEmailNotification extends VerifyEmail
{
    /**
     * Get parameters for verification URL.
     *
     * @param User $notifiable
     */
    public static function getParamsForVerificationUrl($notifiable): array
    {
        $params = [
            'id'   => $notifiable->getHashedKey(),
            'hash' => sha1($notifiable->getEmailForVerification()),
        ];

        $temporarySignedURL = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(config('auth.verification.expire', 60)),
            $params
        );

        $urlParams = [];
        parse_str(Str::after($temporarySignedURL, '?'), $urlParams);

        return $params + $urlParams;
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param User|mixed $notifiable
     */
    protected function verificationUrl($notifiable): string
    {
        // generate domain + path of url
        $prefix = config('apiato.frontend.url') . config('user-container.email-verify-url');

        // generate query string
        $query = Arr::query(static::getParamsForVerificationUrl($notifiable));

        // return full url with query
        return sprintf('%s?%s', $prefix, $query);
    }
}

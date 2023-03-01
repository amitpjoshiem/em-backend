<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Events\Handlers;

use App\Containers\AppSection\Authentication\Events\ApiLogoutEvent;
use App\Containers\AppSection\Otp\Models\Otp;
use App\Containers\AppSection\Otp\Tasks\FindOtpByCondition;
use App\Containers\AppSection\Otp\Tasks\RevokeOtpTokenTask;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckLogoutEventHandler implements ShouldQueue
{
    public ?string $queue = 'auth';

    public function handle(ApiLogoutEvent $event): void
    {
        if (!config('auth.otp')) {
            return;
        }

        /** @var Otp | null  $otp */
        $otp = app(FindOtpByCondition::class)->run([
            'user_id'               => $event->userId,
            'oauth_access_token_id' => $event->tokenId,
        ]);

        if ($otp !== null) {
            app(RevokeOtpTokenTask::class)->run($otp->getKey());
        }
    }
}

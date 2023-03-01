<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Exceptions\VerificationUserEmailWasExpiredException;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\User\UI\API\Requests\EmailVerificationRequest;
use App\Ship\Parents\Actions\Action;
use Illuminate\Auth\Events\Verified;

class EmailVerificationAction extends Action
{
    /**
     * @psalm-return true
     */
    public function run(EmailVerificationRequest $emailData): bool
    {
        $user = app(FindUserByIdTask::class)->run($emailData->id);

        if (!$user) {
            throw new VerificationUserEmailWasExpiredException();
        }

        if (!hash_equals(
            (string)$emailData->hash,
            sha1($user->getEmailForVerification())
        )) {
            throw new VerificationUserEmailWasExpiredException();
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();

            event(new Verified($user));
        }

        return true;
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Authentication\Services\AuthenticatedUser;
use App\Ship\Parents\Actions\Action;

/**
 * Class ResendEmailVerificationAction.
 */
class ResendEmailVerificationAction extends Action
{
    public function __construct(private AuthenticatedUser $authUser)
    {
    }

    public function run(): bool
    {
        $user = $this->authUser->getStrictlyAuthUserModel();

        if ($user->hasVerifiedEmail()) {
            return false;
        }

        $user->sendEmailVerificationNotification();

        return true;
    }
}

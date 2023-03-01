<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Activity\Events\Events\ChangeOwnEmailEvent;
use App\Containers\AppSection\Authentication\Services\AuthenticatedUser;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Containers\AppSection\User\UI\API\Requests\UpdateUserEmailRequest;
use App\Ship\Parents\Actions\Action;

class UpdateUserEmailAction extends Action
{
    public function __construct(private AuthenticatedUser $authUser)
    {
    }

    /**
     * @psalm-return true
     */
    public function run(UpdateUserEmailRequest $emailData): bool
    {
        $user = $this->authUser->getStrictlyAuthUserModel();

        $input = ['email' => $emailData->email];

        if (config('appSection-authentication.require_email_confirmation')) {
            $input['email_verified_at'] = null;
        }

        $oldEmail = $user->email;

        $user = app(UpdateUserTask::class)->run($input, $user->id);

        if (config('appSection-authentication.require_email_confirmation')) {
            $user->sendEmailVerificationNotification();
        }

        event(new ChangeOwnEmailEvent($user->getKey(), $oldEmail));

        return true;
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\SubActions;

use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Authorization\SubActions\AssignUserToRolesSubAction;
use App\Containers\AppSection\User\Data\Transporters\CreateUserTransporter;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\CreateUserByCredentialsTask;
use App\Containers\AppSection\User\Tasks\MarkEmailAsVerifiedTask;
use App\Ship\Parents\Actions\SubAction;
use Illuminate\Auth\Events\Registered;

class RegisterUserSubAction extends SubAction
{
    public function run(CreateUserTransporter $userData, RolesEnum $userTier, bool $forceMarkEmailAsVerified = false): User
    {
        $user = app(CreateUserByCredentialsTask::class)->run(
            $userData->email,
            $userData->password,
            $userData->username,
            $userData->company,
        );

        if ($forceMarkEmailAsVerified) {
            app(MarkEmailAsVerifiedTask::class)->run($user);
        }

        // Assign a base role to user
        app(AssignUserToRolesSubAction::class)->run($user, $userTier->value);

        // Upon this event, newly registered users will automatically be sent an email containing an email verification link.
        event(new Registered($user));

        return $user;
    }
}

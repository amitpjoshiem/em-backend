<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Authorization\Tasks\AssignUserToRolesTask;
use App\Containers\AppSection\User\Data\Transporters\CreateUserTransporter;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\CreateUserByCredentialsTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Auth\Events\Registered;

class RegisterUserAction extends Action
{
    public function run(CreateUserTransporter $userData): User
    {
        /** Create user record in the database and return it. */
        $user = app(CreateUserByCredentialsTask::class)->run(
            $userData->email,
            $userData->password,
            $userData->username,
            $userData->company,
        );

        /** Assign a base role to user */
        app(AssignUserToRolesTask::class)->run($user, ['advisor']);

        /** Upon this event, newly registered users will automatically be sent an email containing an email verification link. */
        event(new Registered($user));

        return $user;
    }
}

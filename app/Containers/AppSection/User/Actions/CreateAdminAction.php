<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Authorization\Tasks\AssignUserToRolesTask;
use App\Containers\AppSection\User\Data\Transporters\CreateUserTransporter;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\CreateUserByCredentialsTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Auth\Events\Registered;

class CreateAdminAction extends Action
{
    public function run(CreateUserTransporter $userData): User
    {
        $admin = app(CreateUserByCredentialsTask::class)->run(
            $userData->email,
            $userData->password,
            $userData->username,
            $userData->company,
        );

        $admin->markEmailAsVerified();

        // NOTE: if not using a single general role for all Admins, comment out that line below. And assign Roles to your users manually.
        app(AssignUserToRolesTask::class)->run($admin, ['admin']);

        /** Upon this event, newly registered users will automatically be sent an email containing an email verification link. */
        event(new Registered($admin));

        return $admin;
    }
}

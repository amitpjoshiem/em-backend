<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Data\Transporters\UserRegisterTransporter;
use App\Containers\AppSection\Admin\Tasks\AdminRegisterUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\SubActions\AssignUserToRolesSubAction;
use App\Containers\AppSection\Authorization\Tasks\FindRoleTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminRegisterUserAction extends Action
{
    public function run(UserRegisterTransporter $userData): User
    {
        /** @var Role $role */
        $role = app(FindRoleTask::class)->run($userData->role);

        if ($role->name === RolesEnum::ASSISTANT && !isset($userData->advisors)) {
            throw ValidationException::withMessages(['advisors' => 'You must set up at least one Advisor for Assistant']);
        }

        if ($role->name === RolesEnum::ADVISOR && !isset($userData->npn)) {
            throw ValidationException::withMessages(['npn' => 'NPN required for Advisor']);
        }

        if ($role->name !== RolesEnum::CEO && $role->name !== RolesEnum::ADMIN && !isset($userData->position)) {
            throw ValidationException::withMessages(['position' => 'Position required for this Role']);
        }

        $userData->password = Hash::make(Str::random());
        /** @var User $user */
        $user = app(AdminRegisterUserTask::class)->run($userData->toArray());

        app(AssignUserToRolesSubAction::class)->run($user, [$userData->role]);

        app(SendCreatePasswordSubAction::class)->run($user);

        if ($user->hasRole(RolesEnum::ASSISTANT)) {
            $user->advisors()->attach($userData->advisors);
        }

        return $user;
    }
}

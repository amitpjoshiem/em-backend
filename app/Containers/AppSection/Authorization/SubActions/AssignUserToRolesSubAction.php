<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\SubActions;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tasks\AssignUserToRolesTask;
use App\Containers\AppSection\Authorization\Tasks\FindRoleTask;
use App\Ship\Parents\Actions\SubAction;
use App\Ship\Parents\Models\UserModel;

class AssignUserToRolesSubAction extends SubAction
{
    public function run(UserModel $user, array | string | int ...$roles): UserModel
    {
        $roles = \is_array($roles[0]) ? $roles[0] : $roles;
        $roles = array_map(static fn (int | string $role): Role => app(FindRoleTask::class)->run($role), $roles);

        return app(AssignUserToRolesTask::class)->run($user, $roles);
    }
}

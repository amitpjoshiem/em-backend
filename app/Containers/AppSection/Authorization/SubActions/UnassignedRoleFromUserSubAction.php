<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\SubActions;

use App\Containers\AppSection\Authorization\Tasks\FindRoleTask;
use App\Containers\AppSection\Authorization\Tasks\UnassignedRoleFromUserTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\SubAction;

class UnassignedRoleFromUserSubAction extends SubAction
{
    public function run(User $user, array $roles): void
    {
        $rolesObject = array_map(fn (string $role) => app(FindRoleTask::class)->run($role), $roles);

        app(UnassignedRoleFromUserTask::class)->run($user, $rolesObject);
    }
}

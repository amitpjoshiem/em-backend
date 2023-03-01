<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Ship\Parents\Models\UserModel;
use App\Ship\Parents\Tasks\Task;

class UnassignedRoleFromUserTask extends Task
{
    public function run(UserModel $user, array $roles): UserModel
    {
        /** @var Role $role */
        foreach ($roles as $role) {
            $user->removeRole($role);
        }

        return $user;
    }
}

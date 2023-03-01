<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Ship\Parents\Models\UserModel;
use App\Ship\Parents\Tasks\Task;
use Spatie\Permission\Contracts\Role;

class RemoveUserRoleTask extends Task
{
    public function run(UserModel $user, string | Role $role): UserModel
    {
        return $user->removeRole($role);
    }
}

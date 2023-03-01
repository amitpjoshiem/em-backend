<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Ship\Parents\Models\UserModel;
use App\Ship\Parents\Tasks\Task;

class AssignUserToRolesTask extends Task
{
    public function run(UserModel $user, array | string $roles): UserModel
    {
        return $user->assignRole((array)$roles);
    }
}

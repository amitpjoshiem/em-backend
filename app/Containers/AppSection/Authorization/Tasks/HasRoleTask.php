<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Ship\Parents\Models\UserModel;
use App\Ship\Parents\Tasks\Task;

class HasRoleTask extends Task
{
    public function run(?UserModel $user, RolesEnum $enum): bool
    {
        if ($user === null) {
            return false;
        }

        return $user->hasRole($enum->value);
    }
}

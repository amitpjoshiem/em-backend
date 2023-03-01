<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Actions;

use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Authorization\Data\Enums\RolesLevelEnum;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tasks\CreateRoleTask;
use App\Ship\Parents\Actions\Action;

class CreateRoleByEnumAction extends Action
{
    public function run(RolesEnum $role, ?string $guardName = null): Role
    {
        $guardName ??= config('auth.defaults.guard');
        $level     = RolesLevelEnum::from($role->value);

        return app(CreateRoleTask::class)->run(
            $role->value,
            $guardName,
            $role->label,
            $role->label,
            $level->value
        );
    }
}

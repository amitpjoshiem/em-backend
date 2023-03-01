<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Actions;

use App\Containers\AppSection\Authorization\Data\Transporters\CreateRoleTransporter;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tasks\CreateRoleTask;
use App\Ship\Parents\Actions\Action;

class CreateRoleAction extends Action
{
    public function run(CreateRoleTransporter $data): Role
    {
        $guardName = $data->guard_name ?? config('auth.defaults.guard');

        return app(CreateRoleTask::class)->run(
            $data->name,
            $guardName,
            $data->description,
            $data->display_name,
            $data->level
        );
    }
}

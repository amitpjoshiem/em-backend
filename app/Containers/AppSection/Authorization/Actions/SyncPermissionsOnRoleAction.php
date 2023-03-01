<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Actions;

use App\Containers\AppSection\Authorization\Data\Transporters\SyncPermissionsOnRoleTransporter;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tasks\FindPermissionsTask;
use App\Containers\AppSection\Authorization\Tasks\FindRoleTask;
use App\Ship\Parents\Actions\Action;

class SyncPermissionsOnRoleAction extends Action
{
    public function run(SyncPermissionsOnRoleTransporter $data): Role
    {
        $role = app(FindRoleTask::class)->run($data->role_id);

        $permissions = app(FindPermissionsTask::class)->run($data->permissions_ids);

        $role->syncPermissions($permissions);

        return $role;
    }
}

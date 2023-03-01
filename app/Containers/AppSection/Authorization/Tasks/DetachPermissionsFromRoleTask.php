<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Containers\AppSection\Authorization\Exceptions\PermissionNotFoundException;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Ship\Parents\Tasks\Task;

class DetachPermissionsFromRoleTask extends Task
{
    public function run(Role $role, array | int $singleOrMultiplePermissionIds): Role
    {
        if (!\is_array($singleOrMultiplePermissionIds)) {
            $singleOrMultiplePermissionIds = [$singleOrMultiplePermissionIds];
        }

        // Remove each permission ID found in the array from that role.
        array_map(static function ($permissionId) use ($role): void {
            try {
                $permission = app(FindPermissionTask::class)->run($permissionId);
                $role->revokePermissionTo($permission);
            } catch (PermissionNotFoundException) {
                // idle
            }
        }, $singleOrMultiplePermissionIds);

        return $role;
    }
}

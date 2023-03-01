<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Containers\AppSection\Authorization\Data\Repositories\PermissionRepository;
use App\Containers\AppSection\Authorization\Exceptions\PermissionNotFoundException;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Ship\Parents\Tasks\Task;

class FindPermissionTask extends Task
{
    public function __construct(protected PermissionRepository $repository)
    {
    }

    public function run(string | int $permissionNameOrId): Permission
    {
        /** @psalm-suppress UndefinedFunction */
        $field = getFieldNameByValue($permissionNameOrId);

        $permission = $this->repository->findWhere([$field => $permissionNameOrId])->first();

        if ($permission === null) {
            throw new PermissionNotFoundException();
        }

        return $permission;
    }
}

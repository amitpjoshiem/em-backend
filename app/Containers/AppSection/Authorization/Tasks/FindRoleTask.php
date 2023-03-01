<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Containers\AppSection\Authorization\Data\Repositories\RoleRepository;
use App\Containers\AppSection\Authorization\Exceptions\RoleNotFoundException;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Ship\Parents\Tasks\Task;

class FindRoleTask extends Task
{
    public function __construct(protected RoleRepository $repository)
    {
    }

    public function run(int | string $roleNameOrId): Role
    {
        /** @psalm-suppress UndefinedFunction */
        $field = getFieldNameByValue($roleNameOrId);

        $role = $this->repository->findWhere([$field => $roleNameOrId])->first();

        if ($role === null) {
            throw new RoleNotFoundException();
        }

        return $role;
    }
}

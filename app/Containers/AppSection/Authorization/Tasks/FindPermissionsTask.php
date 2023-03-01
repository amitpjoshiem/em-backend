<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Containers\AppSection\Authorization\Data\Repositories\PermissionRepository;
use App\Containers\AppSection\Authorization\Exceptions\PermissionNotFoundException;
use App\Containers\AppSection\Authorization\Exceptions\UnsupportedAuthorizationException;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;

class FindPermissionsTask extends Task
{
    public function __construct(protected PermissionRepository $repository)
    {
    }

    public function run(array $permissionNamesOrIds): Collection
    {
        if ($permissionNamesOrIds === []) {
            return Collection::empty();
        }

        // Get first value for get common type of values
        /** @psalm-suppress UndefinedFunction */
        $field = getFieldNameByValue(current($permissionNamesOrIds));

        $permissions = $this->repository->findWhereIn($field, $permissionNamesOrIds);

        if (!($permissions instanceof Collection)) {
            throw new UnsupportedAuthorizationException();
        }

        if ($permissions->isEmpty()) {
            throw new PermissionNotFoundException();
        }

        return $permissions;
    }
}

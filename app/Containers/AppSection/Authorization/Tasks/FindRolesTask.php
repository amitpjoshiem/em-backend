<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Containers\AppSection\Authorization\Data\Repositories\RoleRepository;
use App\Containers\AppSection\Authorization\Exceptions\RoleNotFoundException;
use App\Containers\AppSection\Authorization\Exceptions\UnsupportedAuthorizationException;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;

class FindRolesTask extends Task
{
    public function __construct(protected RoleRepository $repository)
    {
    }

    public function run(array $roleNamesOrIds): Collection
    {
        if ($roleNamesOrIds === []) {
            return Collection::empty();
        }

        // Get first value for get common type of values
        /** @psalm-suppress UndefinedFunction */
        $field = getFieldNameByValue(current($roleNamesOrIds));

        $roles = $this->repository->findWhereIn($field, $roleNamesOrIds);

        if (!($roles instanceof Collection)) {
            throw new UnsupportedAuthorizationException();
        }

        if ($roles->isEmpty()) {
            throw new RoleNotFoundException();
        }

        return $roles;
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Containers\AppSection\Authorization\Data\Repositories\RoleRepository;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteRoleTask extends Task
{
    public function __construct(protected RoleRepository $repository)
    {
    }

    /**
     * Delete the record from the roles table.
     *
     * @throws DeleteResourceFailedException
     */
    public function run(int | Role $role): bool
    {
        if ($role instanceof Role) {
            $role = $role->getKey();
        }

        try {
            return (bool)$this->repository->delete($role);
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException(previous: $exception);
        }
    }
}

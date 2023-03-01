<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Containers\AppSection\Authorization\Data\Repositories\PermissionRepository;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllPermissionsTask extends Task
{
    public function __construct(protected PermissionRepository $repository)
    {
    }

    public function run(bool $skipPagination = false): Collection | LengthAwarePaginator
    {
        return $skipPagination ? $this->repository->all() : $this->repository->paginate();
    }

    /**
     * @throws RepositoryException
     */
    public function filterByGuard(string $guard): self
    {
        $this->repository->pushCriteria(new ThisEqualThatCriteria('guard_name', $guard));

        return $this;
    }
}

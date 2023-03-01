<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\Tasks;

use App\Containers\AppSection\Activity\Data\Repositories\UserActivityRepository;
use App\Containers\AppSection\User\Traits\TaskTraits\FilterByCompanyTrait;
use App\Containers\AppSection\User\Traits\TaskTraits\FilterByUserRepositoryTrait;
use App\Ship\Criterias\Eloquent\OrderByFieldCriteria;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Traits\TaskTraits\WithRelationsRepositoryTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetAllActivitiesTask extends Task
{
    use FilterByCompanyTrait;
    use FilterByUserRepositoryTrait;
    use WithRelationsRepositoryTrait;

    public function __construct(protected UserActivityRepository $repository)
    {
    }

    public function run(bool $skipPagination = false): Collection|LengthAwarePaginator
    {
        return $skipPagination ? $this->repository->all() : $this->repository->paginate();
    }

    public function sortByCreatedAt(): self
    {
        $this->repository->pushCriteria(new OrderByFieldCriteria('created_at', 'desc'));

        return $this;
    }
}

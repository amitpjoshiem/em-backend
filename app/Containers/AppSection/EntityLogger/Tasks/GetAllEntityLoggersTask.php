<?php

declare(strict_types=1);

namespace App\Containers\AppSection\EntityLogger\Tasks;

use App\Containers\AppSection\EntityLogger\Data\Repositories\EntityLogRepository;
use App\Ship\Criterias\Eloquent\ThisMatchListThat;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetAllEntityLoggersTask extends Task
{
    public function __construct(protected EntityLogRepository $repository)
    {
    }

    public function run(bool $skipPagination = false): Collection | LengthAwarePaginator
    {
        return $skipPagination ? $this->repository->all() : $this->repository->paginate();
    }

    public function filterByUsers(array $user_ids): self
    {
        $this->repository->pushCriteria(new ThisMatchListThat('user_id', $user_ids));

        return $this;
    }

    public function withRelations(array $relations): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria($relations));

        return $this;
    }
}

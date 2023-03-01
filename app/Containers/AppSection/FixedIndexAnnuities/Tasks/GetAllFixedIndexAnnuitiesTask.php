<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Tasks;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Repositories\FixedIndexAnnuitiesRepository;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetAllFixedIndexAnnuitiesTask extends Task
{
    public function __construct(protected FixedIndexAnnuitiesRepository $repository)
    {
    }

    public function run(bool $skipPagination = false): Collection | LengthAwarePaginator
    {
        return $skipPagination ? $this->repository->all() : $this->repository->paginate();
    }

    public function filterByMember(int $memberId): self
    {
        $this->repository->pushCriteria(new ThisEqualThatCriteria('member_id', $memberId));

        return $this;
    }
}

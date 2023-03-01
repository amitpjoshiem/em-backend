<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Tasks;

use App\Containers\AppSection\AssetsConsolidations\Data\Repositories\AssetsConsolidationsExportRepository;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllAssetsConsolidationsExportsTask extends Task
{
    public function __construct(protected AssetsConsolidationsExportRepository $repository)
    {
    }

    public function run(bool $skipPagination = true): Collection | LengthAwarePaginator
    {
        return $skipPagination ? $this->repository->all() : $this->repository->paginate();
    }

    public function filterByMember(int $member_id): self
    {
        $this->repository->pushCriteria(new ThisEqualThatCriteria('member_id', $member_id));

        return $this;
    }

    public function filterByUser(int $user_id): self
    {
        $this->repository->pushCriteria(new ThisEqualThatCriteria('user_id', $user_id));

        return $this;
    }

    /**
     * @throws RepositoryException
     */
    public function withMember(): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria('member'));

        return $this;
    }

    /**
     * @throws RepositoryException
     */
    public function withMedia(): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria('media'));

        return $this;
    }
}

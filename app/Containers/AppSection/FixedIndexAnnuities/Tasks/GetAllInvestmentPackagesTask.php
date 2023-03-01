<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Tasks;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Repositories\InvestmentPackageRepository;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetAllInvestmentPackagesTask extends Task
{
    public function __construct(protected InvestmentPackageRepository $repository)
    {
    }

    public function run(bool $skipPagination = false): Collection | LengthAwarePaginator
    {
        return $skipPagination ? $this->repository->all() : $this->repository->paginate();
    }

    public function filterByFixedIndexAnnuities(int $fixedIndexAnnuitiesId): self
    {
        $this->repository->pushCriteria(new ThisEqualThatCriteria('fixed_index_annuities_id', $fixedIndexAnnuitiesId));

        return $this;
    }

    public function withMedia(): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria(['media']));

        return $this;
    }
}

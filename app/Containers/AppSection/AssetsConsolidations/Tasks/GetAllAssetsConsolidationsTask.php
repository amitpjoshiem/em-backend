<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Tasks;

use App\Containers\AppSection\AssetsConsolidations\Data\Repositories\AssetsConsolidationsRepository;
use App\Ship\Criterias\Eloquent\OrderByFieldCriteria;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;

class GetAllAssetsConsolidationsTask extends Task
{
    public function __construct(protected AssetsConsolidationsRepository $repository)
    {
    }

    public function run(): Collection
    {
        return $this->repository->all();
    }

    public function filterByMember(int $member_id): self
    {
        $this->repository->pushCriteria(new ThisEqualThatCriteria('member_id', $member_id));

        return $this;
    }

    public function orderById(): self
    {
        $this->repository->pushCriteria(new OrderByFieldCriteria('id', 'asc'));

        return $this;
    }

    public function withTable(): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria(['table']));

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Tasks;

use App\Containers\AppSection\AssetsIncome\Data\Repositories\AssetsIncomeValueRepository;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;

class GetAllValuesTask extends Task
{
    public function __construct(protected AssetsIncomeValueRepository $repository)
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
}

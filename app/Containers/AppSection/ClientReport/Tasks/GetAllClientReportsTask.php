<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Tasks;

use App\Containers\AppSection\ClientReport\Data\Repositories\ClientReportRepository;
use App\Ship\Criterias\Eloquent\OrderByFieldCriteria;
use App\Ship\Criterias\Eloquent\ThisBetweenDatesCriteria;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Criterias\Eloquent\ThisLessThanDateCriteria;
use App\Ship\Criterias\Eloquent\ThisMatchListThat;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;

class GetAllClientReportsTask extends Task
{
    public function __construct(protected ClientReportRepository $repository)
    {
    }

    public function run(): Collection
    {
        return $this->repository->all();
    }

    public function withMember(): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria('member'));

        return $this;
    }

    public function filterByMember(int $memberId): self
    {
        $this->repository->pushCriteria(new ThisEqualThatCriteria('member_id', $memberId));

        return $this;
    }

    public function filterByContractsId(?array $contracts): self
    {
        if ($contracts === null) {
            return $this;
        }

        $this->repository->pushCriteria(new ThisMatchListThat('id', $contracts));

        return $this;
    }

    public function orderByOriginationDate(): self
    {
        $this->repository->pushCriteria(new OrderByFieldCriteria('origination_date', 'desc'));

        return $this;
    }

    public function filterByYear(bool $currentYear = true): self
    {
        $criteria = $currentYear ?
            new ThisBetweenDatesCriteria('issue_at', now()->subYear(), now()) :
            new ThisLessThanDateCriteria('issue_at', now()->subYear());
        $this->repository->pushCriteria($criteria);

        return $this;
    }
}

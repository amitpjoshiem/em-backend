<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\Tasks;

use App\Containers\AppSection\Client\Data\Repositories\ClientRepository;
use App\Ship\Criterias\Eloquent\FilterByRelationCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class GetGroupedLeadsTask extends Task
{
    public function __construct(protected ClientRepository $repository)
    {
    }

    public function run(string $type, string $field): Collection
    {
        $type    = GetPreparedPipelineData::SORT_TYPES[$type]['db_format'];
        $dateRaw = sprintf("DATE_FORMAT(%s, '%s')", $field, $type);

        return $this->repository
            ->getBuilder()
            ->selectRaw(sprintf('%s as period, count(id) as count', $dateRaw))
            ->whereNotNull($field)
            ->groupByRaw($dateRaw)->get();
    }

    public function filterByUser(int $userId): self
    {
        $this->repository->pushCriteria(new FilterByRelationCriteria('member', 'user_id', value: $userId));

        return $this;
    }

    public function filterByCompany(int $companyId): self
    {
        $this->repository->pushCriteria(new FilterByRelationCriteria('member.user', 'company_id', value: $companyId));

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Dashboard\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceChildOpportunityRepository;
use App\Containers\AppSection\User\Traits\TaskTraits\FilterByCompanyTrait;
use App\Containers\AppSection\User\Traits\TaskTraits\FilterByUserRepositoryTrait;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class GetDashboardMemberListTask extends Task
{
    use FilterByCompanyTrait;
    use FilterByUserRepositoryTrait;

    public function __construct(protected SalesforceChildOpportunityRepository $repository)
    {
    }

    public function run(): Collection
    {
        return $this->repository->orderBy('amount', 'desc')->limit(config('appSection-dashboard.member_list_count'));
    }

    public function withMember(): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria('member'));

        return $this;
    }
}

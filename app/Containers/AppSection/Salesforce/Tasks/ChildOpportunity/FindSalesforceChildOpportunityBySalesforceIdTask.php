<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceChildOpportunityRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Parents\Tasks\Task;

class FindSalesforceChildOpportunityBySalesforceIdTask extends Task
{
    public function __construct(protected SalesforceChildOpportunityRepository $repository)
    {
    }

    public function run(string $salesforceId): ?SalesforceChildOpportunity
    {
        return $this->repository->findWhere(['salesforce_id' => $salesforceId])->first();
    }

    public function withParentOpportunity(): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria('opportunity'));

        return $this;
    }
}

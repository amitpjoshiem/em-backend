<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\Opportunity;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceOpportunityRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Ship\Parents\Tasks\Task;

class FindSalesforceOpportunityBySalesforceIdTask extends Task
{
    public function __construct(protected SalesforceOpportunityRepository $repository)
    {
    }

    public function run(string $salesforceId): ?SalesforceOpportunity
    {
        return $this->repository->findByField([
            'salesforce_id'     => $salesforceId,
        ])->first();
    }
}

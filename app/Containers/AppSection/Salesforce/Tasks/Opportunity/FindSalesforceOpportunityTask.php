<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\Opportunity;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceOpportunityRepository;
use App\Containers\AppSection\Salesforce\Exceptions\FindSalesforceOpportunityException;
use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Ship\Parents\Tasks\Task;

class FindSalesforceOpportunityTask extends Task
{
    public function __construct(protected SalesforceOpportunityRepository $repository)
    {
    }

    /**
     * @throws FindSalesforceOpportunityException
     */
    public function run(int $memberId): SalesforceOpportunity
    {
        $salesforceOpportunity = $this->repository->findByField([
            'member_id'     => $memberId,
        ])->first();

        if ($salesforceOpportunity === null) {
            throw new FindSalesforceOpportunityException();
        }

        return $salesforceOpportunity;
    }
}

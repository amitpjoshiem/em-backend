<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\Opportunity;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceOpportunityRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Traits\TaskTraits\WithRelationsRepositoryTrait;

class FindSalesforceOpportunityByIdTask extends Task
{
    use WithRelationsRepositoryTrait;

    public function __construct(protected SalesforceOpportunityRepository $repository)
    {
    }

    public function run(int $id): SalesforceOpportunity
    {
        return $this->repository->find($id);
    }
}

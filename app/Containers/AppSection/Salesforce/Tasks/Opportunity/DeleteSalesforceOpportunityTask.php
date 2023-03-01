<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\Opportunity;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceOpportunityRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteSalesforceOpportunityTask extends Task
{
    public function __construct(protected SalesforceOpportunityRepository $repository)
    {
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run(SalesforceOpportunity $opportunity, bool $withApi = true): bool
    {
        if ($withApi) {
            $opportunity->api()->delete();
        }

        try {
            return (bool)$this->repository->delete($opportunity->getKey());
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

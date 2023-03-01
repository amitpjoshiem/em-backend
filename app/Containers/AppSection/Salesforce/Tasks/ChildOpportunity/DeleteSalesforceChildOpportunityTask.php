<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceChildOpportunityRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteSalesforceChildOpportunityTask extends Task
{
    public function __construct(protected SalesforceChildOpportunityRepository $repository)
    {
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run(SalesforceChildOpportunity $childOpportunity, bool $withApi = true): bool
    {
        if ($withApi) {
            $childOpportunity->api()->delete();
        }

        try {
            return (bool)$this->repository->delete($childOpportunity->getKey());
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

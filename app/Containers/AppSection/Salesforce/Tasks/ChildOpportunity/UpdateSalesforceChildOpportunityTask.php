<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceChildOpportunityRepository;
use App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters\SaveSalesforceChildOpportunityTransporter;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateSalesforceChildOpportunityTask extends Task
{
    public function __construct(protected SalesforceChildOpportunityRepository $repository)
    {
    }

    public function run(int $id, SaveSalesforceChildOpportunityTransporter $data): SalesforceChildOpportunity
    {
        try {
            return $this->repository->update($data->toArray(), $id);
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }
}

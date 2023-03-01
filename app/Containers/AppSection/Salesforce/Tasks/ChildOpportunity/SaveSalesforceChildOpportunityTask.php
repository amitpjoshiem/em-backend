<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceChildOpportunityRepository;
use App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters\SaveSalesforceChildOpportunityTransporter;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class SaveSalesforceChildOpportunityTask extends Task
{
    public function __construct(protected SalesforceChildOpportunityRepository $repository)
    {
    }

    public function run(SaveSalesforceChildOpportunityTransporter $data): SalesforceChildOpportunity
    {
        try {
            return $this->repository->updateOrCreate(
                [
                    'salesforce_id' => $data->salesforce_id,
                ],
                $data->toArray()
            );
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

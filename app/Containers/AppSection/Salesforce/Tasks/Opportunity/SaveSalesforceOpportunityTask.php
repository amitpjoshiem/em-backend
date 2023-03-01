<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\Opportunity;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceOpportunityRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class SaveSalesforceOpportunityTask extends Task
{
    public function __construct(protected SalesforceOpportunityRepository $repository)
    {
    }

    public function run(int $memberId, array $data): SalesforceOpportunity
    {
        try {
            return $this->repository->updateOrCreate([
                'member_id' => $memberId,
            ], $data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceUserRepository;
use App\Ship\Parents\Tasks\Task;

class CheckSalesforceUserTask extends Task
{
    public function __construct(protected SalesforceUserRepository $repository)
    {
    }

    public function run(string $salesforceId): bool
    {
        $salesforceUser = $this->repository->findByField('salesforce_id', $salesforceId)->first();

        return $salesforceUser !== null;
    }
}

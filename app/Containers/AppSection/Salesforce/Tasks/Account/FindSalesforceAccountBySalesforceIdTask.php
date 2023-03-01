<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\Account;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceAccountRepository;
use App\Containers\AppSection\Salesforce\Exceptions\FindSalesforceAccountException;
use App\Containers\AppSection\Salesforce\Models\SalesforceAccount;
use App\Ship\Parents\Tasks\Task;

class FindSalesforceAccountBySalesforceIdTask extends Task
{
    public function __construct(protected SalesforceAccountRepository $repository)
    {
    }

    /**
     * @throws FindSalesforceAccountException
     */
    public function run(string $salesforceId): ?SalesforceAccount
    {
        return $this->repository->findByField(['salesforce_id'  => $salesforceId])->first();
    }
}

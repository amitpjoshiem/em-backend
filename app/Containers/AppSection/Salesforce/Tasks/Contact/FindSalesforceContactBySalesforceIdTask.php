<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\Contact;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceContactRepository;
use App\Containers\AppSection\Salesforce\Exceptions\FindSalesforceContactException;
use App\Containers\AppSection\Salesforce\Models\SalesforceContact;
use App\Ship\Parents\Tasks\Task;

class FindSalesforceContactBySalesforceIdTask extends Task
{
    public function __construct(protected SalesforceContactRepository $repository)
    {
    }

    /**
     * @throws FindSalesforceContactException
     */
    public function run(string $salesforceId): ?SalesforceContact
    {
        return $this->repository->findByField([
            'salesforce_id'     => $salesforceId,
        ])->first();
    }
}

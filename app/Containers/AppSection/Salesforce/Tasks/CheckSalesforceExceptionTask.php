<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceImportExceptionRepository;
use App\Ship\Parents\Tasks\Task;

class CheckSalesforceExceptionTask extends Task
{
    public function __construct(protected SalesforceImportExceptionRepository $repository)
    {
    }

    public function run(string $salesforceId, string $object): bool
    {
        return $this->repository->findWhere([
            'salesforce_id' => $salesforceId,
            'object'        => $object,
        ])->first() !== null;
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceImportRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceImport;
use App\Ship\Parents\Tasks\Task;

class FindSalesforceImportTask extends Task
{
    public function __construct(protected SalesforceImportRepository $repository)
    {
    }

    public function run(string $object): ?SalesforceImport
    {
        return $this->repository->orderBy('end_date', 'desc')->findByField('object', $object)->first();
    }
}

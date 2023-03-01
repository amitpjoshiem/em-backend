<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceImportRepository;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class FindAllSalesforceImportsTask extends Task
{
    public function __construct(protected SalesforceImportRepository $repository)
    {
    }

    public function run(): Collection
    {
        return $this->repository->all();
    }
}

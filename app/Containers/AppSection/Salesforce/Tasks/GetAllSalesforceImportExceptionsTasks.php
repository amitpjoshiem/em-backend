<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceImportExceptionRepository;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;

class GetAllSalesforceImportExceptionsTasks extends Task
{
    public function __construct(protected SalesforceImportExceptionRepository $repository)
    {
    }

    public function run(): Collection
    {
        return $this->repository->all();
    }
}

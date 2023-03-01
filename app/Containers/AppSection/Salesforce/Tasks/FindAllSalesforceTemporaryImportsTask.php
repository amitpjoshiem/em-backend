<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceTemporaryImportRepository;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Traits\TaskTraits\WithRelationsRepositoryTrait;
use Illuminate\Support\Collection;

class FindAllSalesforceTemporaryImportsTask extends Task
{
    use WithRelationsRepositoryTrait;

    public function __construct(protected SalesforceTemporaryImportRepository $repository)
    {
    }

    public function run(): Collection
    {
        return $this->repository->all();
    }
}

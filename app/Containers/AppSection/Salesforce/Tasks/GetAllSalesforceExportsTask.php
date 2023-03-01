<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceTemporaryExportRepository;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Traits\TaskTraits\WithRelationsRepositoryTrait;
use Illuminate\Support\Collection;

class GetAllSalesforceExportsTask extends Task
{
    use WithRelationsRepositoryTrait;

    public function __construct(protected SalesforceTemporaryExportRepository $repository)
    {
    }

    public function run(): Collection
    {
        return $this->repository->all();
    }
}

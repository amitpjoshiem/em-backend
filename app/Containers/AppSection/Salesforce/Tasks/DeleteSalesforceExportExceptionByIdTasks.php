<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceExportExceptionRepository;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Traits\TaskTraits\WithRelationsRepositoryTrait;

class DeleteSalesforceExportExceptionByIdTasks extends Task
{
    use WithRelationsRepositoryTrait;

    public function __construct(protected SalesforceExportExceptionRepository $repository)
    {
    }

    public function run(int $id): bool
    {
        return (bool)$this->repository->delete($id);
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceTemporaryImportRepository;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class FindSalesforceTemporaryImportByUserIdTask extends Task
{
    public function __construct(protected SalesforceTemporaryImportRepository $repository)
    {
    }

    public function run(string $userId): Collection
    {
        return $this->repository->findByField('owner_id', $userId);
    }
}

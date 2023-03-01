<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceTemporaryExportRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceTemporaryExport;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Tasks\Task;

class CreateSalesforceExportTask extends Task
{
    public function __construct(protected SalesforceTemporaryExportRepository $repository)
    {
    }

    public function run(int $entityId, string $entityClass, string $action, ?string $salesforce_id = null): SalesforceTemporaryExport
    {
        try {
            return $this->repository->create([
                'object_id'     => $entityId,
                'object_class'  => $entityClass,
                'action'        => $action,
                'salesforce_id' => $salesforce_id,
            ]);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

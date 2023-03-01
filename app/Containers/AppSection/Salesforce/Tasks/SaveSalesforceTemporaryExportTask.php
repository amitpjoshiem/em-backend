<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceTemporaryExportRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceTemporaryExport;
use App\Ship\Parents\Tasks\Task;

class SaveSalesforceTemporaryExportTask extends Task
{
    public function __construct(protected SalesforceTemporaryExportRepository $repository)
    {
    }

    public function run(string $objectClass, int $objectId, string $action): SalesforceTemporaryExport
    {
        return $this->repository->updateOrCreate([
            'object_id'       => $objectId,
            'object_class'    => $objectClass,
            'action'          => $action,
        ], ['updated_at' => now()]);
    }
}

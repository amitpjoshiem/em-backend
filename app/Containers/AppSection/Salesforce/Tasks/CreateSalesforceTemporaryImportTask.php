<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceTemporaryImportRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceTemporaryImport;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Tasks\Task;

class CreateSalesforceTemporaryImportTask extends Task
{
    public function __construct(protected SalesforceTemporaryImportRepository $repository)
    {
    }

    public function run(string $object, string $salesforce_id, string $owner_id): SalesforceTemporaryImport
    {
        try {
            return $this->repository->updateOrCreate([
                'owner_id'          => $owner_id,
                'salesforce_id'     => $salesforce_id,
                'object'            => $object,
            ], [
                'owner_id'          => $owner_id,
                'salesforce_id'     => $salesforce_id,
                'object'            => $object,
            ]);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

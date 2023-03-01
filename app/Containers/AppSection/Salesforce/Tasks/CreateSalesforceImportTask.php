<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceImportRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceImport;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Tasks\Task;

class CreateSalesforceImportTask extends Task
{
    public function __construct(protected SalesforceImportRepository $repository)
    {
    }

    public function run(string $object, int $startDate, int $endDate): SalesforceImport
    {
        try {
            return $this->repository->updateOrCreate([
                'object'            => $object,
            ], [
                'start_date'        => $startDate,
                'end_date'          => $endDate,
                'object'            => $object,
            ]);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

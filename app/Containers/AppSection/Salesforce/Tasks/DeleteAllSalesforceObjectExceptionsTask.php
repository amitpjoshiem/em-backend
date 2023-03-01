<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceImportExceptionRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteAllSalesforceObjectExceptionsTask extends Task
{
    public function __construct(protected SalesforceImportExceptionRepository $repository)
    {
    }

    public function run(string $object): bool
    {
        try {
            return (bool)$this->repository->deleteWhere([
                'object' => $object,
            ]);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

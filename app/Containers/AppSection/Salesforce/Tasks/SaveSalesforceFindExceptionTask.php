<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceImportExceptionRepository;
use App\Containers\AppSection\Salesforce\Exceptions\ImportExceptions\FindObjectInfoException;
use App\Containers\AppSection\Salesforce\Models\SalesforceImportException;
use App\Ship\Core\Abstracts\Exceptions\Exception as CoreException;
use App\Ship\Parents\Tasks\Task;

class SaveSalesforceFindExceptionTask extends Task
{
    public function __construct(protected SalesforceImportExceptionRepository $repository)
    {
    }

    public function run(FindObjectInfoException $exception): SalesforceImportException
    {
        $message = match (true) {
            $exception->exception instanceof CoreException       => $exception->exception->getRootMessage(),
            default                                              => $exception->exception->getMessage(),
        };

        $trace = match (true) {
            $exception->exception instanceof CoreException       => $exception->exception->getRootTrace(),
            default                                              => $exception->exception->getTraceAsString(),
        };

        return $this->repository->updateOrCreate([
            'salesforce_id'       => $exception->salesforce_id,
            'object'              => $exception->object,
        ], [
            'salesforce_data' => null,
            'trace'           => $trace,
            'message'         => $message,
        ]);
    }
}

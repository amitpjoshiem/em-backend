<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceImportExceptionRepository;
use App\Containers\AppSection\Salesforce\Exceptions\ImportExceptions\SaveObjectException;
use App\Containers\AppSection\Salesforce\Models\SalesforceImportException;
use App\Ship\Core\Abstracts\Exceptions\Exception as CoreException;
use App\Ship\Parents\Tasks\Task;

class SaveSalesforceExceptionTask extends Task
{
    public function __construct(protected SalesforceImportExceptionRepository $repository)
    {
    }

    public function run(SaveObjectException $exception): SalesforceImportException
    {
        $message = match (true) {
            $exception->data->exception instanceof CoreException => $exception->data->exception->getRootMessage(),
            default                                              => $exception->data->exception->getMessage(),
        };

        $trace = match (true) {
            $exception->data->exception instanceof CoreException => $exception->data->exception->getRootTrace(),
            default                                              => $exception->data->exception->getTraceAsString(),
        };

        return $this->repository->updateOrCreate([
            'salesforce_id'       => $exception->data->salesforce_id,
            'object'              => $exception->data->object,
        ], [
            'salesforce_data' => $exception->data->salesforceData,
            'trace'           => $trace,
            'message'         => $message,
        ]);
    }
}

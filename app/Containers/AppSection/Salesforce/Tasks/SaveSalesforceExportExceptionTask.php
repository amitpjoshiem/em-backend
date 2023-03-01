<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceExportExceptionRepository;
use App\Containers\AppSection\Salesforce\Exceptions\ExportExceptions\ApiRequestException;
use App\Containers\AppSection\Salesforce\Models\SalesforceExportException;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class SaveSalesforceExportExceptionTask extends Task
{
    public function __construct(protected SalesforceExportExceptionRepository $repository)
    {
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run(ApiRequestException $exception, string $objectType, int $objectId): SalesforceExportException
    {
        try {
            return $this->repository->updateOrCreate([
                'object_type' => $objectType,
                'object_id'   => $objectId,
            ], [
                'request'  => $exception->requestData,
                'response' => $exception->responseData,
                'method'   => $exception->method,
                'trace'    => $exception->getTraceAsString(),
                'url'      => $exception->url,
            ]);
        } catch (Exception $e) {
            throw new CreateResourceFailedException(previous: $e);
        }
    }
}

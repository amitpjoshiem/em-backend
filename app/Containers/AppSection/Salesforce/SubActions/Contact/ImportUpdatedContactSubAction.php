<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions\Contact;

use App\Containers\AppSection\Salesforce\Data\Transporters\SaveObjectExceptionTransporter;
use App\Containers\AppSection\Salesforce\Exceptions\ImportExceptions\MultipleExceptions;
use App\Containers\AppSection\Salesforce\Exceptions\ImportExceptions\SaveObjectException;
use App\Containers\AppSection\Salesforce\Models\SalesforceContact;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Ship\Parents\Actions\SubAction;
use Carbon\CarbonImmutable;
use Exception;
use function app;

class ImportUpdatedContactSubAction extends SubAction
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        $importedIds = $this->apiService->contact()->getUpdated($startDate, $endDate);

        $exceptions = new MultipleExceptions();

        if (!isset($importedIds['ids'])) {
            return;
        }

        foreach (array_chunk($importedIds['ids'], 10) as $chunkedImportedIds) {
            $importedData    = $this->apiService->contact()->findAll($chunkedImportedIds);

            foreach ($importedData as $info) {
                try {
                    app(SaveImportedContactSubAction::class)->run($info, $info['Id']);
                } catch (Exception $exception) {
                    $exception = new SaveObjectExceptionTransporter([
                        'salesforce_id'  => $info['Id'],
                        'object'         => SalesforceContact::class,
                        'salesforceData' => $info,
                        'exception'      => $exception,
                    ]);
                    $exceptions->addException(new SaveObjectException($exception));
                }
            }
        }

        if (!$exceptions->getExceptions()->isEmpty()) {
            throw $exceptions;
        }
    }
}

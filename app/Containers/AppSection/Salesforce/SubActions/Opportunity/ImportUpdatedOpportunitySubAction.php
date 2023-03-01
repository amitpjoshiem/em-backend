<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions\Opportunity;

use App\Containers\AppSection\Salesforce\Data\Transporters\SaveObjectExceptionTransporter;
use App\Containers\AppSection\Salesforce\Exceptions\ImportExceptions\MultipleExceptions;
use App\Containers\AppSection\Salesforce\Exceptions\ImportExceptions\SaveObjectException;
use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Ship\Parents\Actions\SubAction;
use Carbon\CarbonImmutable;
use Exception;
use function app;

class ImportUpdatedOpportunitySubAction extends SubAction
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        $importedIds = $this->apiService->opportunity()->getUpdated($startDate, $endDate);

        $exceptions = new MultipleExceptions();

        if (!isset($importedIds['ids'])) {
            return;
        }

        foreach (array_chunk($importedIds['ids'], 10) as $chunkedImportedIds) {
            $importedData = $this->apiService->opportunity()->findAll($chunkedImportedIds);
            foreach ($importedData as $info) {
                try {
                    $salesforceId = $info['Id'];
                    app(SaveImportedOpportunitySubAction::class)->run($info, $salesforceId);
                } catch (Exception $exception) {
                    $exception = new SaveObjectExceptionTransporter([
                        'salesforce_id'  => $info['Id'],
                        'object'         => SalesforceOpportunity::class,
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

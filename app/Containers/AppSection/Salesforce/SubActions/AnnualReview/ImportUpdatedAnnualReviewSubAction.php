<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions\AnnualReview;

use App\Containers\AppSection\Salesforce\Data\Transporters\SaveObjectExceptionTransporter;
use App\Containers\AppSection\Salesforce\Exceptions\ImportExceptions\MultipleExceptions;
use App\Containers\AppSection\Salesforce\Exceptions\ImportExceptions\SaveObjectException;
use App\Containers\AppSection\Salesforce\Models\SalesforceAnnualReview;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Ship\Parents\Actions\SubAction;
use Carbon\CarbonImmutable;
use Exception;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Spatie\DataTransferObject\Exceptions\ValidationException;
use function app;

class ImportUpdatedAnnualReviewSubAction extends SubAction
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    /**
     * @throws UnknownProperties
     * @throws ValidationException
     * @throws MultipleExceptions
     */
    public function run(CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        $importedIds = $this->apiService->annualReview()->getUpdated($startDate, $endDate);

        $exceptions = new MultipleExceptions();

        if (!isset($importedIds['ids'])) {
            return;
        }

        foreach (array_chunk($importedIds['ids'], 10) as $chunkedImportedIds) {
            $importedData = $this->apiService->annualReview()->findAll($chunkedImportedIds);
            foreach ($importedData as $annualReviewInfo) {
                try {
                    app(SaveImportedAnnualReviewSubAction::class)->run($annualReviewInfo, $annualReviewInfo['Id']);
                } catch (Exception $exception) {
                    $exception = new SaveObjectExceptionTransporter([
                        'salesforce_id'  => $annualReviewInfo['Id'],
                        'object'         => SalesforceAnnualReview::class,
                        'salesforceData' => $annualReviewInfo,
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

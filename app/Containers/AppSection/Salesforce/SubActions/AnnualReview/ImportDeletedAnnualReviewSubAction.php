<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions\AnnualReview;

use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\Tasks\AnnualReview\DeleteSalesforceAnnualReviewTask;
use App\Containers\AppSection\Salesforce\Tasks\AnnualReview\FindSalesforceAnnualReviewBySalesforceIdTask;
use App\Ship\Parents\Actions\SubAction;
use Carbon\CarbonImmutable;
use function app;

class ImportDeletedAnnualReviewSubAction extends SubAction
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        $deleted = $this->apiService->annualReview()->getDeleted($startDate, $endDate);

        if (!isset($deleted['deletedRecords'])) {
            return;
        }

        foreach ($deleted['deletedRecords'] as $item) {
            if (isset($item['id'])) {
                $salesforceId = $item['id'];
                $annualReview = app(FindSalesforceAnnualReviewBySalesforceIdTask::class)->run($salesforceId);

                if ($annualReview !== null) {
                    app(DeleteSalesforceAnnualReviewTask::class)->run($annualReview, false);
                }
            }
        }
    }
}

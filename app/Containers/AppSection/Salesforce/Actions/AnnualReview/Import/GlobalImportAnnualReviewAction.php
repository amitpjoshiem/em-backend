<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\AnnualReview\Import;

use App\Containers\AppSection\Salesforce\Actions\GlobalImportObjectInterface;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\SubActions\AnnualReview\SaveImportedAnnualReviewSubAction;
use App\Ship\Parents\Actions\Action;

class GlobalImportAnnualReviewAction extends Action implements GlobalImportObjectInterface
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(): void
    {
        $annualReviews = $this->apiService->annualReview()->globalImport();

        foreach ($annualReviews['records'] as $annualReview) {
            if ($annualReview['IsDeleted'] === true) {
                continue;
            }

            $salesforceId = $annualReview['Id'];
            app(SaveImportedAnnualReviewSubAction::class)->run($annualReview, $salesforceId);
        }
    }
}

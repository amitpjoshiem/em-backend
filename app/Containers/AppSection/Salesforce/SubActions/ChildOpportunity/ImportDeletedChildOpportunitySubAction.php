<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions\ChildOpportunity;

use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity\DeleteSalesforceChildOpportunityTask;
use App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity\FindSalesforceChildOpportunityBySalesforceIdTask;
use App\Ship\Parents\Actions\SubAction;
use Carbon\CarbonImmutable;
use function app;

class ImportDeletedChildOpportunitySubAction extends SubAction
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        $deleted = $this->apiService->childOpportunity()->getDeleted($startDate, $endDate);

        if (!isset($deleted['deletedRecords'])) {
            return;
        }

        foreach ($deleted['deletedRecords'] as $item) {
            if (isset($item['id'])) {
                $salesforceId = $item['id'];
                /** @var SalesforceChildOpportunity | null $childOpportunity */
                $childOpportunity = app(FindSalesforceChildOpportunityBySalesforceIdTask::class)->run($salesforceId);

                if ($childOpportunity !== null) {
                    app(DeleteSalesforceChildOpportunityTask::class)->run($childOpportunity, false);
                }
            }
        }
    }
}

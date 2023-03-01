<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions\Opportunity;

use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\Tasks\Opportunity\DeleteSalesforceOpportunityTask;
use App\Containers\AppSection\Salesforce\Tasks\Opportunity\FindSalesforceOpportunityBySalesforceIdTask;
use App\Ship\Parents\Actions\SubAction;
use Carbon\CarbonImmutable;
use function app;

class ImportDeletedOpportunitySubAction extends SubAction
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        $deleted = $this->apiService->opportunity()->getDeleted($startDate, $endDate);

        if (!isset($deleted['deletedRecords'])) {
            return;
        }

        foreach ($deleted['deletedRecords'] as $item) {
            if (isset($item['id'])) {
                $salesforceId = $item['id'];
                /** @var SalesforceOpportunity | null $opportunity */
                $opportunity = app(FindSalesforceOpportunityBySalesforceIdTask::class)->run($salesforceId);

                if ($opportunity !== null) {
                    app(DeleteSalesforceOpportunityTask::class)->run($opportunity, false);
                }
            }
        }
    }
}

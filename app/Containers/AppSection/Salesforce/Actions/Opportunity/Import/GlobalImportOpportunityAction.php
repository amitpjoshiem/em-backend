<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\Opportunity\Import;

use App\Containers\AppSection\Salesforce\Actions\GlobalImportObjectInterface;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\SubActions\Opportunity\SaveImportedOpportunitySubAction;
use App\Ship\Parents\Actions\Action;
use function app;

class GlobalImportOpportunityAction extends Action implements GlobalImportObjectInterface
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(): void
    {
        $opportunities = $this->apiService->opportunity()->globalImport();

        foreach ($opportunities['records'] as $opportunity) {
            if ($opportunity['IsDeleted'] === true) {
                continue;
            }

            $salesforceId = $opportunity['Id'];
            app(SaveImportedOpportunitySubAction::class)->run($opportunity, $salesforceId);
        }
    }
}

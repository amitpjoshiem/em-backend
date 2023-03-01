<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\ChildOpportunity\Import;

use App\Containers\AppSection\Salesforce\Actions\GlobalImportObjectInterface;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\SubActions\ChildOpportunity\SaveImportedChildOpportunitySubAction;
use App\Ship\Parents\Actions\Action;
use function app;

class GlobalImportChildOpportunityAction extends Action implements GlobalImportObjectInterface
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(): void
    {
        $childOpportunities = $this->apiService->childOpportunity()->globalImport();

        foreach ($childOpportunities['records'] as $childOpportunity) {
            if ($childOpportunity['IsDeleted'] === true) {
                continue;
            }

            app(SaveImportedChildOpportunitySubAction::class)->run($childOpportunity, $childOpportunity['Id']);
        }
    }
}

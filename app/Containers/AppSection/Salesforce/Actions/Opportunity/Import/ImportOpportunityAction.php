<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\Opportunity\Import;

use App\Containers\AppSection\Salesforce\Actions\ImportObjectInterface;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\SubActions\Opportunity\ImportDeletedOpportunitySubAction;
use App\Containers\AppSection\Salesforce\SubActions\Opportunity\ImportUpdatedOpportunitySubAction;
use App\Ship\Parents\Actions\Action;
use Carbon\CarbonImmutable;
use function app;

class ImportOpportunityAction extends Action implements ImportObjectInterface
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        app(ImportDeletedOpportunitySubAction::class)->run($startDate, $endDate);
        app(ImportUpdatedOpportunitySubAction::class)->run($startDate, $endDate);
    }
}

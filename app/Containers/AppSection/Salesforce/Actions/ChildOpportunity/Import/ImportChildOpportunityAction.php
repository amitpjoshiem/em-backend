<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\ChildOpportunity\Import;

use App\Containers\AppSection\Salesforce\Actions\ImportObjectInterface;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\SubActions\ChildOpportunity\ImportDeletedChildOpportunitySubAction;
use App\Containers\AppSection\Salesforce\SubActions\ChildOpportunity\ImportUpdatedChildOpportunitySubAction;
use App\Ship\Parents\Actions\Action;
use Carbon\CarbonImmutable;
use function app;

class ImportChildOpportunityAction extends Action implements ImportObjectInterface
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        app(ImportDeletedChildOpportunitySubAction::class)->run($startDate, $endDate);
        app(ImportUpdatedChildOpportunitySubAction::class)->run($startDate, $endDate);
    }
}

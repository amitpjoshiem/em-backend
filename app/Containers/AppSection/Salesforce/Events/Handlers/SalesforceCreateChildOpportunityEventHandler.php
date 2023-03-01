<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Events\Handlers;

use App\Containers\AppSection\Salesforce\Events\Events\SalesforceCreateChildOpportunityEvent;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity\FindSalesforceChildOpportunityByIdTask;
use Illuminate\Contracts\Queue\ShouldQueue;

class SalesforceCreateChildOpportunityEventHandler implements ShouldQueue
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function handle(SalesforceCreateChildOpportunityEvent $event): void
    {
        /** @var SalesforceChildOpportunity $childOpportunity */
        $childOpportunity                  = app(FindSalesforceChildOpportunityByIdTask::class)
            ->withRelations(['opportunity'])
            ->run($event->childOpportunityId);

        $childOpportunity->api()->create();
    }
}

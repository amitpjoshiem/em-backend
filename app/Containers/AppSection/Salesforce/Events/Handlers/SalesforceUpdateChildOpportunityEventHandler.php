<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Events\Handlers;

use App\Containers\AppSection\Salesforce\Events\Events\SalesforceUpdateChildOpportunityEvent;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity\FindSalesforceChildOpportunityByIdTask;
use Illuminate\Contracts\Queue\ShouldQueue;

class SalesforceUpdateChildOpportunityEventHandler implements ShouldQueue
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function handle(SalesforceUpdateChildOpportunityEvent $event): void
    {
        /** @var SalesforceChildOpportunity $childOpportunity */
        $childOpportunity                  = app(FindSalesforceChildOpportunityByIdTask::class)
            ->withRelations(['opportunity'])
            ->run($event->id);

        $childOpportunity->api()->update();
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Events\Handlers;

use App\Containers\AppSection\Client\Tasks\UpdateClientByMemberIdTask;
use App\Containers\AppSection\Salesforce\Events\Events\SalesforceUpdateOpportunityEvent;
use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Containers\AppSection\Salesforce\Tasks\Opportunity\FindSalesforceOpportunityByIdTask;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateSalesforceOpportunityEventHandler implements ShouldQueue
{
    public function handle(SalesforceUpdateOpportunityEvent $event): void
    {
        /** @var SalesforceOpportunity $opportunity */
        $opportunity = app(FindSalesforceOpportunityByIdTask::class)->run($event->id);
        $opportunity = $opportunity->load('member.client');

        if ($opportunity->member->client === null) {
            return;
        }

        if ($opportunity->member->client->closed_win_lost === null && ($opportunity->stage === 'Closed Win' || $opportunity->stage === 'Closed Lost')) {
            app(UpdateClientByMemberIdTask::class)->run($opportunity->member->getKey(), ['closed_win_lost' => now()]);
        }
    }
}

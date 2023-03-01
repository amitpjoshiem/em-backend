<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Events\Handlers;

use App\Containers\AppSection\Member\Events\Events\CreateMemberEvent;
use App\Containers\AppSection\Salesforce\Actions\CreateMemberInSaleforceAction;
use App\Containers\AppSection\Salesforce\Actions\Opportunity\CreateOpportunityAction;
use App\Containers\AppSection\Salesforce\Data\Enums\OpportunityStageEnum;
use App\Containers\AppSection\Salesforce\Data\Transporters\CreateMemberInSaleforceTransporter;
use App\Containers\AppSection\Salesforce\Data\Transporters\OpportunityTransporters\CreateSalesforceOpportunityTransporter;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckMemberCreateEventHandler implements ShouldQueue
{
    public function handle(CreateMemberEvent $event): void
    {
        $input = new CreateMemberInSaleforceTransporter([
            'member_id' => $event->entity->getKey(),
        ]);
        app(CreateMemberInSaleforceAction::class)->run($input);

        $opportunityInput = new CreateSalesforceOpportunityTransporter([
            'member_id'  => $event->entity->getKey(),
            'close_date' => now()->addMonths(3),
            'stage_name' => OpportunityStageEnum::NONE,
        ]);
        app(CreateOpportunityAction::class)->run($opportunityInput);
    }
}

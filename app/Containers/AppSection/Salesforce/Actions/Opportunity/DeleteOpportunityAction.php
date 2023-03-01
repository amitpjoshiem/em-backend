<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\Opportunity;

use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Salesforce\Data\Transporters\OpportunityTransporters\DeleteSalesforceOpportunityTransporter;
use App\Containers\AppSection\Salesforce\Tasks\Opportunity\DeleteSalesforceOpportunityTask;
use App\Ship\Parents\Actions\Action;

class DeleteOpportunityAction extends Action
{
    public function run(DeleteSalesforceOpportunityTransporter $input): void
    {
        $member = app(FindMemberByIdTask::class)->run($input->member_id);

        app(DeleteSalesforceOpportunityTask::class)->run($member->salesforce->opportunity);
    }
}

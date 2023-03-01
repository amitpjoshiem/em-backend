<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\Opportunity;

use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Salesforce\Data\Transporters\OpportunityTransporters\UpdateSalesforceOpportunityTransporter;
use App\Ship\Parents\Actions\Action;

class UpdateOpportunityAction extends Action
{
    public function run(UpdateSalesforceOpportunityTransporter $input): void
    {
        /** @var Member $member */
        $member      = app(FindMemberByIdTask::class)->run($input->member_id);

        $member->salesforce->opportunity->api()->update();
    }
}

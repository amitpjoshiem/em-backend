<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\Opportunity;

use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Salesforce\Data\Transporters\OpportunityTransporters\FindSalesforceOpportunityTransporter;
use App\Ship\Parents\Actions\Action;

class FindOpportunityAction extends Action
{
    public function run(FindSalesforceOpportunityTransporter $input): array
    {
        $member = app(FindMemberByIdTask::class)->run($input->member_id);

        return $member->salesforce->opportunity->api()->find();
    }
}

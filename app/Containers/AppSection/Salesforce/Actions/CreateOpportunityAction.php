<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions;

use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Salesforce\Data\Transporters\CreateOpportunityTransporter;
use App\Containers\AppSection\Salesforce\Data\Transporters\OpportunityTransporters\CreateSalesforceOpportunityTransporter;
use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Containers\AppSection\Salesforce\SubActions\Opportunity\CreateOpportunitySubAction;
use App\Ship\Parents\Actions\Action;

class CreateOpportunityAction extends Action
{
    public function __construct()
    {
    }

    public function run(CreateOpportunityTransporter $input): SalesforceOpportunity
    {
        $data = new CreateSalesforceOpportunityTransporter([
            'member_id'     => $input->member_id,
            'close_date'    => now()->addMonths(3),
            'stage_name'    => Member::PROSPECT,
        ]);

        return app(CreateOpportunitySubAction::class)->run($data);
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions\Opportunity;

use App\Containers\AppSection\Salesforce\Data\Transporters\OpportunityTransporters\CreateSalesforceOpportunityTransporter;
use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Containers\AppSection\Salesforce\Tasks\Account\FindSalesforceAccountTask;
use App\Containers\AppSection\Salesforce\Tasks\Opportunity\FindSalesforceOpportunityTask;
use App\Containers\AppSection\Salesforce\Tasks\Opportunity\SaveSalesforceOpportunityTask;
use App\Ship\Parents\Actions\SubAction;
use Exception;
use function app;

class CreateOpportunitySubAction extends SubAction
{
    public function run(CreateSalesforceOpportunityTransporter $input): SalesforceOpportunity
    {
        $account               = app(FindSalesforceAccountTask::class)->run($input->member_id);

        try {
            $opportunity = app(FindSalesforceOpportunityTask::class)->run($input->member_id);
        } catch (Exception) {
            /** @var SalesforceOpportunity $opportunity */
            $opportunity = app(SaveSalesforceOpportunityTask::class)->run($input->member_id, [
                'salesforce_account_id' => $account->getKey(),
                'stage'                 => $input->stage_name,
                'close_date'            => $input->close_date,
                'member_id'             => $input->member_id,
            ]);
            $opportunity->api()->create();
            app(CheckOpportunityStageSubAction::class)->run($opportunity->getKey());
        }

        return $opportunity;
    }
}

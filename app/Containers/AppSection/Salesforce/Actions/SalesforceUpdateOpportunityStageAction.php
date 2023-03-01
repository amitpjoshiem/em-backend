<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions;

use App\Containers\AppSection\Salesforce\Data\Enums\OpportunityStageEnum;
use App\Containers\AppSection\Salesforce\Data\Transporters\UpdateOpportunityStageTransporter;
use App\Containers\AppSection\Salesforce\Models\SalesforceAccount;
use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Containers\AppSection\Salesforce\SubActions\Opportunity\CheckOpportunityStageSubAction;
use App\Containers\AppSection\Salesforce\Tasks\Account\FindSalesforceAccountTask;
use App\Containers\AppSection\Salesforce\Tasks\Opportunity\SaveSalesforceOpportunityTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Validation\ValidationException;

class SalesforceUpdateOpportunityStageAction extends Action
{
    public function run(UpdateOpportunityStageTransporter $input): SalesforceOpportunity
    {
        if ($input->stage === OpportunityStageEnum::CLOSED) {
            if ($input->closed_status === null) {
                throw ValidationException::withMessages(['closed_status' => 'You must set Status for Closed Stage']);
            }

            $input->stage = $input->closed_status;
        }

        $data = $input->sanitizeInput([
            'stage',
            'date_of_1st',
            'date_of_2nd',
            'date_of_3rd',
            'result_1st_appt',
            'result_2nd_appt',
            'result_3rd_appt',
            'status_1st_appt',
            'status_2nd_appt',
            'status_3rd_appt',
        ]);

        /** @var SalesforceAccount $salesforceAccount */
        $salesforceAccount = app(FindSalesforceAccountTask::class)->run($input->member_id);

        $data['salesforce_account_id'] = $salesforceAccount->getKey();

        /** @var SalesforceOpportunity $opportunity */
        $opportunity = app(SaveSalesforceOpportunityTask::class)->run($input->member_id, $data);

        $opportunity->api()->update();

        app(CheckOpportunityStageSubAction::class)->run($opportunity->getKey());

        return $opportunity;
    }
}

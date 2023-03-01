<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions\Opportunity;

use App\Containers\AppSection\Salesforce\Data\Enums\OpportunityStageEnum;
use App\Containers\AppSection\Salesforce\Events\Events\SalesforceUpdateOpportunityEvent;
use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\SubActions\SaveImportedObjectInterface;
use App\Containers\AppSection\Salesforce\Tasks\Account\FindSalesforceAccountBySalesforceIdTask;
use App\Containers\AppSection\Salesforce\Tasks\CreateSalesforceTemporaryImportTask;
use App\Containers\AppSection\Salesforce\Tasks\Opportunity\SaveSalesforceOpportunityTask;
use App\Ship\Parents\Actions\SubAction;
use Illuminate\Support\Carbon;
use function app;

class SaveImportedOpportunitySubAction extends SubAction implements SaveImportedObjectInterface
{
    public function run(array $info, string $objectId, ?int $userId = null): void
    {
        if ($info['AccountId'] === null) {
            return;
        }

        $salesforceAccount = app(FindSalesforceAccountBySalesforceIdTask::class)->run($info['AccountId']);

        if ($salesforceAccount === null) {
            app(CreateSalesforceTemporaryImportTask::class)->run(SalesforceApiService::OPPORTUNITY, $objectId, $info['OwnerId']);

            return;
        }

        $data = [
            'member_id'             => $salesforceAccount->member_id,
            'stage'                 => OpportunityStageEnum::getValue($info['StageName']),
            'investment_size'       => $info['Total_Investment_Size__c'] ?? SalesforceOpportunity::DEFAULT_INVESTMENT_SIZE,
            'close_date'            => Carbon::create($info['CloseDate']),
            'salesforce_account_id' => $salesforceAccount->getKey(),
            'salesforce_id'         => $objectId,
            'result_1st_appt'       => $info['X1st_Appt_Results__c'] ?? null,
            'result_2nd_appt'       => $info['X2nd_Appt_Results__c'] ?? null,
            'result_3rd_appt'       => $info['X3rd_Appt_Results__c'] ?? null,
            'status_1st_appt'       => $info['X1st_Appointment_Status__c'] ?? null,
            'status_2nd_appt'       => $info['X2nd_Appointment_Status__c'] ?? null,
            'status_3rd_appt'       => $info['X3rd_Appointment_Status__c'] ?? null,
            'date_of_1st'           => isset($info['Date_of_1st__c']) ? Carbon::create($info['Date_of_1st__c']) : null,
            'date_of_2nd'           => isset($info['Date_of_2nd__c']) ? Carbon::create($info['Date_of_2nd__c']) : null,
            'date_of_3rd'           => isset($info['Date_of_3rd__c']) ? Carbon::create($info['Date_of_3rd__c']) : null,
        ];
        /** @var SalesforceOpportunity $opportunity */
        $opportunity = app(SaveSalesforceOpportunityTask::class)->run($salesforceAccount->member_id, $data);

        app(CheckOpportunityStageSubAction::class)->run($opportunity->getKey());

        event(new SalesforceUpdateOpportunityEvent($opportunity->getKey()));
    }
}

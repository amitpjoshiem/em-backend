<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions\ChildOpportunity;

use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Notification\Events\Events\SalesforceImportChildOpportunityNotificationEvent;
use App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters\SaveSalesforceChildOpportunityTransporter;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\SubActions\SaveImportedObjectInterface;
use App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity\SaveSalesforceChildOpportunityTask;
use App\Containers\AppSection\Salesforce\Tasks\CreateSalesforceTemporaryImportTask;
use App\Containers\AppSection\Salesforce\Tasks\Opportunity\FindSalesforceOpportunityBySalesforceIdTask;
use App\Ship\Parents\Actions\SubAction;
use Carbon\Carbon;
use function app;
use function event;

class SaveImportedChildOpportunitySubAction extends SubAction implements SaveImportedObjectInterface
{
    public function run(array $info, string $objectId, ?int $userId = null): void
    {
        if (!$this->checkKeys($info)) {
            return;
        }

        $salesforceOpportunity = app(FindSalesforceOpportunityBySalesforceIdTask::class)->run($info['Opportunity__c']);

        if ($salesforceOpportunity === null) {
            app(CreateSalesforceTemporaryImportTask::class)->run(SalesforceApiService::CHILD_OPPORTUNITY, $objectId, $info['CreatedById']);

            return;
        }

        $member = app(FindMemberByIdTask::class)->run($salesforceOpportunity->member_id);

        $data   = new SaveSalesforceChildOpportunityTransporter([
            'member_id'                 => $salesforceOpportunity->member_id,
            'salesforce_id'             => $objectId,
            'salesforce_opportunity_id' => $salesforceOpportunity->getKey(),
            'amount'                    => (float)$info['Opportunity_Amount__c'],
            'stage'                     => $info['Child_Opportunity_Stage__c'] ?? 'No Stage',
            'created_at'                => Carbon::create($info['CreatedDate']),
            'type'                      => $info['Type__c'],
            'name'                      => $info['Name'],
            'close_date'                => Carbon::create($info['Close_Date__c']),
            'user_id'                   => $member->user_id,
        ]);
        app(SaveSalesforceChildOpportunityTask::class)->run($data);
        event(new SalesforceImportChildOpportunityNotificationEvent($member->getKey(), $member->user_id));
    }

    private function checkKeys(array $info): bool
    {
        return isset($info['Id']) && isset($info['CreatedById']) && isset($info['Opportunity__c']);
    }
}

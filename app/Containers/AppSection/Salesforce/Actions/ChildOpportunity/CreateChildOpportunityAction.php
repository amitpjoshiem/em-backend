<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\ChildOpportunity;

use App\Containers\AppSection\Activity\Events\Events\MemberChildOpportunityAddedEvent;
use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters\CreateSalesforceChildOpportunityTransporter;
use App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters\SaveSalesforceChildOpportunityTransporter;
use App\Containers\AppSection\Salesforce\Events\Events\SalesforceCreateChildOpportunityEvent;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity\CreateSalesforceChildOpportunityTask;
use App\Containers\AppSection\Salesforce\Tasks\Opportunity\FindSalesforceOpportunityTask;
use App\Ship\Parents\Actions\Action;

class CreateChildOpportunityAction extends Action
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(CreateSalesforceChildOpportunityTransporter $input): SalesforceChildOpportunity
    {
        $user                          = app(GetStrictlyAuthenticatedUserTask::class)->run();
        $member                        = app(FindMemberByIdTask::class)->run($input->member_id);
        $opportunity                   = app(FindSalesforceOpportunityTask::class)->run($input->member_id);
        $data                          = new SaveSalesforceChildOpportunityTransporter([
            'member_id'                  => $member->getKey(),
            'salesforce_opportunity_id'  => $opportunity->getKey(),
            'amount'                     => $input->amount,
            'stage'                      => $input->stage,
            'created_at'                 => now(),
            'close_date'                 => $input->close_date,
            'user_id'                    => $member->user_id,
            'name'                       => $input->name,
            'type'                       => $input->type,
        ]);
        $childOpportunity              = app(CreateSalesforceChildOpportunityTask::class)->run($data);

        event(new SalesforceCreateChildOpportunityEvent($childOpportunity->getKey()));

        event(new MemberChildOpportunityAddedEvent($user->getKey(), $member->getKey(), $childOpportunity->getKey()));

        return $childOpportunity;
    }
}

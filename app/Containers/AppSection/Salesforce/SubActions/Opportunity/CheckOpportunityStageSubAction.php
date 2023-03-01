<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions\Opportunity;

use App\Containers\AppSection\Client\Jobs\CreateClientForMemberJob;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\UpdateMemberTask;
use App\Containers\AppSection\Salesforce\Data\Enums\OpportunityStageEnum;
use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Containers\AppSection\Salesforce\Tasks\Opportunity\FindSalesforceOpportunityByIdTask;
use App\Containers\AppSection\User\SubActions\SendRestoreUserMailSubAction;
use App\Containers\AppSection\User\Tasks\DeleteUserTask;
use App\Containers\AppSection\User\Tasks\RestoreUserTask;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\SubAction;
use function app;

class CheckOpportunityStageSubAction extends SubAction
{
    /**
     * @var string[]
     */
    private const LEAD_STAGES = [
        OpportunityStageEnum::APPOINTMENT_1ST,
        OpportunityStageEnum::APPOINTMENT_2ND,
        OpportunityStageEnum::APPOINTMENT_3RD,
    ];

    /**
     * @var string[]
     */
    private const PROSPECT_STAGES = [
        OpportunityStageEnum::PLACE_HOLDER_ACCT,
        OpportunityStageEnum::PAPERWORK_SIGNED,
        OpportunityStageEnum::COMMISSION_PAID,
        OpportunityStageEnum::CONTRACT_DELIVERY_FREE_LOOK_PERIOD,
    ];

    /**
     * @throws DeleteResourceFailedException
     * @throws UpdateResourceFailedException
     */
    public function run(int $opportunityId): void
    {
        /** @var SalesforceOpportunity $opportunity */
        $opportunity = app(FindSalesforceOpportunityByIdTask::class)
            ->withRelations(['member.client.user'])->run($opportunityId);

        if ($opportunity->stage === OpportunityStageEnum::NONE) {
            return;
        }

        if ($opportunity->stage === OpportunityStageEnum::CLOSED_LOST) {
            if ($opportunity->member->client !== null) {
                $this->setClosedLost($opportunity);
            }

            return;
        }

        $type = match (true) {
            \in_array($opportunity->stage, self::LEAD_STAGES, true) => Member::LEAD,
            \in_array($opportunity->stage, self::PROSPECT_STAGES, true) => Member::PROSPECT,
            $opportunity->stage === OpportunityStageEnum::CLOSED_WON => Member::CLIENT,
        };

        if ($type === Member::LEAD && $opportunity->member->client === null) {
            $type = Member::PRE_LEAD;
            dispatch(new CreateClientForMemberJob($opportunity->member_id));
        } else {
            $this->checkMemberHasAccess($opportunity->member);
        }

        app(UpdateMemberTask::class)->run($opportunity->member_id, ['type' => $type]);
    }

    /**
     * @throws DeleteResourceFailedException
     */
    private function setClosedLost(SalesforceOpportunity $opportunity): void
    {
        app(DeleteUserTask::class)->run($opportunity->member->client->user);
    }

    private function checkMemberHasAccess(Member $member): void
    {
        if ($member->client === null) {
            return;
        }

        if ($member->client->user->isDeleted()) {
            app(RestoreUserTask::class)->run($member->client->user->getKey());
            app(SendRestoreUserMailSubAction::class)->run($member->client->user);
        }
    }
}

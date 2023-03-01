<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions;

use App\Containers\AppSection\Activity\Events\Events\LeadConvertToProspectEvent;
use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Member\Data\Transporters\ConvertMemberTransporter;
use App\Containers\AppSection\Member\Events\Events\ConvertFromLeadMemberEvent;
use App\Containers\AppSection\Member\Events\Events\UpdateMemberEvent;
use App\Containers\AppSection\Member\Exceptions\CantConvertMemberTypeException;
use App\Containers\AppSection\Member\Exceptions\NotFoundMember;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\ConvertLeadTask;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Ship\Parents\Actions\Action;

class ConvertLeadAction extends Action
{
    /**
     * @throws NotFoundMember
     */
    public function run(ConvertMemberTransporter $memberData): Member
    {
        $user   = app(GetStrictlyAuthenticatedUserTask::class)->run();
        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->run($memberData->id);

        if ($member->type !== Member::LEAD) {
            throw new CantConvertMemberTypeException();
        }

        $updatedMember = app(ConvertLeadTask::class)->run($member->id);

        event(new LeadConvertToProspectEvent($user->getKey(), $member->getKey()));

        event(new ConvertFromLeadMemberEvent($member->getKey()));

        event(new UpdateMemberEvent($updatedMember));

        return $updatedMember;
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Actions;

use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Yodlee\Data\Transporters\GetYodleeMemberStatusTransporter;
use App\Containers\AppSection\Yodlee\Data\Transporters\OutputYodleeStatusTransporter;
use App\Ship\Parents\Actions\Action;

class GetYodleeMemberStatusAction extends Action
{
    public function run(GetYodleeMemberStatusTransporter $input): OutputYodleeStatusTransporter
    {
        $member = app(FindMemberByIdTask::class)->run($input->member_id);

        if ($member->yodlee === null) {
            return new OutputYodleeStatusTransporter();
        }

        return new OutputYodleeStatusTransporter([
            'yodlee_created'    => true,
            'link_sent'         => $member->yodlee->isSentLinkValidStatus(),
            'link_used'         => $member->yodlee->isUsedLinkValidStatus(),
            'link_ttl'          => $member->yodlee->link_expired?->diffInMilliseconds() ?? 0,
            'provider_count'    => $member->yodlee->api()->providers()->getCount(),
        ]);
    }
}

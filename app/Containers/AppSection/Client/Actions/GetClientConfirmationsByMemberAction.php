<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Actions;

use App\Containers\AppSection\Client\Data\Transporters\GetConfirmationsByMemberTransporter;
use App\Containers\AppSection\Client\Data\Transporters\OutputClientConfirmationTransporter;
use App\Containers\AppSection\Client\Exceptions\ClientNotFoundException;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Ship\Parents\Actions\Action;

class GetClientConfirmationsByMemberAction extends Action
{
    public function run(GetConfirmationsByMemberTransporter $data): OutputClientConfirmationTransporter
    {
        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->run($data->member_id);

        if ($member->client === null) {
            throw new ClientNotFoundException();
        }

        return app(GetClientConfirmationSubAction::class)->run($member->client);
    }
}

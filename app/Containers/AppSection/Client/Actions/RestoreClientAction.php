<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Actions;

use App\Containers\AppSection\Client\Data\Transporters\RestoreClientTransporter;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\User\Tasks\RestoreUserTask;
use App\Ship\Parents\Actions\Action;

class RestoreClientAction extends Action
{
    public function run(RestoreClientTransporter $data): void
    {
        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->withRelations(['client.user'])->run($data->member_id);

        app(RestoreUserTask::class)->run($member->client->user->getKey());
    }
}

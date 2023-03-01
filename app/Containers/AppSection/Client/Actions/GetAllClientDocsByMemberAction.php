<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Actions;

use App\Containers\AppSection\Client\Data\Transporters\GetAllClientDocsByMemberTransporter;
use App\Containers\AppSection\Client\Data\Transporters\OutputClientDocsTransporter;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Ship\Parents\Actions\Action;

class GetAllClientDocsByMemberAction extends Action
{
    public function run(GetAllClientDocsByMemberTransporter $data): OutputClientDocsTransporter
    {
        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->run($data->member_id);

        return new OutputClientDocsTransporter([
            'status'    => $member->client->getAttribute($data->collection),
            'documents' => $member->client->getCollectionDocs($data->collection),
        ]);
    }
}

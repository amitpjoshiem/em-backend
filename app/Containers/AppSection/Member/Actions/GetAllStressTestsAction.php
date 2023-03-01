<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions;

use App\Containers\AppSection\Member\Data\Transporters\GetAllStressTestsTransporter;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Ship\Parents\Actions\Action;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

class GetAllStressTestsAction extends Action
{
    public function run(GetAllStressTestsTransporter $data): MediaCollection
    {
        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->run($data->member_id);

        return $member->getStressTests();
    }
}

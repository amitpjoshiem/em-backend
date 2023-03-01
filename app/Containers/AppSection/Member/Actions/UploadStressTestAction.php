<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions;

use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\SubActions\AttachMediaFromUuidsToModelSubAction;
use App\Containers\AppSection\Member\Data\Transporters\UploadStressTestTransporter;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Ship\Parents\Actions\Action;

class UploadStressTestAction extends Action
{
    public function run(UploadStressTestTransporter $uploadData): void
    {
        $member = app(FindMemberByIdTask::class)->run($uploadData->member_id);

        app(AttachMediaFromUuidsToModelSubAction::class)->run($member, $uploadData->uuids, MediaCollectionEnum::STRESS_TEST);
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Actions;

use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\UploadAssetsConsolidationsDocsTransporter;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\SubActions\AttachMediaFromUuidsToModelSubAction;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Ship\Parents\Actions\Action;

class UploadAssetsConsolidationsDocsAction extends Action
{
    public function run(UploadAssetsConsolidationsDocsTransporter $uploadData): void
    {
        $member = app(FindMemberByIdTask::class)->run($uploadData->member_id);

        app(AttachMediaFromUuidsToModelSubAction::class)->run($member, $uploadData->uuids, MediaCollectionEnum::ASSETS_CONSOLIDATIONS_DOCS);
    }
}

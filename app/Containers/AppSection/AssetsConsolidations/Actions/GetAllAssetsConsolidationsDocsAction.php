<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Actions;

use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\GetAllAssetsConsolidationsDocsTransporter;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Ship\Parents\Actions\Action;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

class GetAllAssetsConsolidationsDocsAction extends Action
{
    public function run(GetAllAssetsConsolidationsDocsTransporter $data): MediaCollection
    {
        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->run($data->member_id);

        return $member->getAssetsConsolidationDocs();
    }
}

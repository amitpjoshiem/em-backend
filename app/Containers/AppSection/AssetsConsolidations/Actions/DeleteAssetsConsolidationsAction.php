<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Actions;

use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\DeleteAssetsConsolidationsTransporter;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidations;
use App\Containers\AppSection\AssetsConsolidations\Tasks\DeleteAssetsConsolidationsTask;
use App\Containers\AppSection\AssetsConsolidations\Tasks\FindAssetsConsolidationsByIdTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class DeleteAssetsConsolidationsAction extends Action
{
    public function run(DeleteAssetsConsolidationsTransporter $assetsconsolidationsData): Collection
    {
        /** @var AssetsConsolidations $assetsConsolidation */
        $assetsConsolidation = app(FindAssetsConsolidationsByIdTask::class)->run($assetsconsolidationsData->id);
        $member_id           = $assetsConsolidation->member->getKey();
        app(DeleteAssetsConsolidationsTask::class)->run($assetsconsolidationsData->id);

        return app(GetAllCalculatedAssetsConsolidationsSubAction::class)->run($member_id);
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Actions;

use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\UpdateAssetsConsolidationsTransporter;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidations;
use App\Containers\AppSection\AssetsConsolidations\Tasks\UpdateAssetsConsolidationsTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class UpdateAssetsConsolidationsAction extends Action
{
    public function run(UpdateAssetsConsolidationsTransporter $assetsconsolidationsData): Collection
    {
        /** @var AssetsConsolidations $assetConsolidation */
        $assetConsolidation = app(UpdateAssetsConsolidationsTask::class)->run($assetsconsolidationsData->id, $assetsconsolidationsData->except('id')->toArray());

        return app(GetAllCalculatedAssetsConsolidationsSubAction::class)->run($assetConsolidation->member->getKey());
    }
}

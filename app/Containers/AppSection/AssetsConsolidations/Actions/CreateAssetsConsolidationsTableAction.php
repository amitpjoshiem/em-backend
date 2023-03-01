<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Actions;

use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\CreateAssetsConsolidationsTableTransporter;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsTable;
use App\Containers\AppSection\AssetsConsolidations\Tasks\CreateAssetsConsolidationsTableTask;
use App\Containers\AppSection\AssetsConsolidations\Tasks\CreateAssetsConsolidationsTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class CreateAssetsConsolidationsTableAction extends Action
{
    public function run(CreateAssetsConsolidationsTableTransporter $assetsconsolidationsData): Collection
    {
        /** @var AssetsConsolidationsTable $table */
        $table = app(CreateAssetsConsolidationsTableTask::class)->run($assetsconsolidationsData->name, $assetsconsolidationsData->member_id);

        app(CreateAssetsConsolidationsTask::class)->run($assetsconsolidationsData->member_id, $table);

        return app(GetAllCalculatedAssetsConsolidationsSubAction::class)->run($assetsconsolidationsData->member_id);
    }
}

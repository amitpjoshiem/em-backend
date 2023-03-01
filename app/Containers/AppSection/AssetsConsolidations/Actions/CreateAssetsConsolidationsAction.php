<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Actions;

use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\CreateAssetsConsolidationsTransporter;
use App\Containers\AppSection\AssetsConsolidations\Exceptions\TableHasMaxRowsException;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsTable;
use App\Containers\AppSection\AssetsConsolidations\Tasks\CreateAssetsConsolidationsTask;
use App\Containers\AppSection\AssetsConsolidations\Tasks\GetAssetsConsolidationsTableTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class CreateAssetsConsolidationsAction extends Action
{
    public function run(CreateAssetsConsolidationsTransporter $assetsconsolidationsData): Collection
    {
        /** @var AssetsConsolidationsTable $table */
        $table = app(GetAssetsConsolidationsTableTask::class)->withRows()->run($assetsconsolidationsData->table);

        if ($table->rows->count() >= config('appSection-assetsConsolidations.table_rows')) {
            throw new TableHasMaxRowsException();
        }

        app(CreateAssetsConsolidationsTask::class)->run($assetsconsolidationsData->member_id, $table);

        return app(GetAllCalculatedAssetsConsolidationsSubAction::class)->run($assetsconsolidationsData->member_id);
    }
}

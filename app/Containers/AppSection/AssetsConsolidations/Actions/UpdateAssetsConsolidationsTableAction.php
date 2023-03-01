<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Actions;

use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\UpdateAssetsConsolidationsTableTransporter;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsTable;
use App\Containers\AppSection\AssetsConsolidations\Tasks\GetAssetsConsolidationsTableTask;
use App\Containers\AppSection\AssetsConsolidations\Tasks\UpdateAssetsConsolidationsByTableTask;
use App\Containers\AppSection\AssetsConsolidations\Tasks\UpdateAssetsConsolidationsTableTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class UpdateAssetsConsolidationsTableAction extends Action
{
    public function run(UpdateAssetsConsolidationsTableTransporter $tableData): Collection
    {
        /** @var AssetsConsolidationsTable $table */
        $table = app(GetAssetsConsolidationsTableTask::class)->withMember()->run($tableData->table_id);

        app(UpdateAssetsConsolidationsTableTask::class)->run($table->getKey(), $tableData->except('table_id')->toArray());

        if (isset($tableData->wrap_fee)) {
            app(UpdateAssetsConsolidationsByTableTask::class)->run($table->getKey(), ['wrap_fee' => $tableData->wrap_fee]);
        }

        return app(GetAllCalculatedAssetsConsolidationsSubAction::class)->run($table->member->getKey());
    }
}

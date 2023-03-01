<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Actions;

use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\GetAllAssetsConsolidationsTransporter;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsTable;
use App\Containers\AppSection\AssetsConsolidations\Tasks\CreateAssetsConsolidationsTableTask;
use App\Containers\AppSection\AssetsConsolidations\Tasks\CreateAssetsConsolidationsTask;
use App\Containers\AppSection\AssetsConsolidations\Tasks\GetAllAssetsConsolidationsTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class GetAllAssetsConsolidationsAction extends Action
{
    /**
     * @var string
     */
    private const BASE_TABLE = 'Base Table';

    public function run(GetAllAssetsConsolidationsTransporter $input): Collection
    {
        /** @var Collection $assetsConsolidations */
        $assetsConsolidations = app(GetAllAssetsConsolidationsTask::class)->filterByMember($input->member_id)->withTable()->run();

        if ($assetsConsolidations->isEmpty()) {
            /** @var AssetsConsolidationsTable $table */
            $table = app(CreateAssetsConsolidationsTableTask::class)->run(self::BASE_TABLE, $input->member_id);
            app(CreateAssetsConsolidationsTask::class)->run($input->member_id, $table);
        }

        return app(GetAllCalculatedAssetsConsolidationsSubAction::class)->run($input->member_id);
    }
}

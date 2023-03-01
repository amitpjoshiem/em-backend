<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Actions;

use App\Containers\AppSection\AssetsConsolidations\Tasks\CalculateAssetsConsolidationsTask;
use App\Containers\AppSection\AssetsConsolidations\Tasks\GetAllAssetsConsolidationsTask;
use App\Ship\Parents\Actions\SubAction;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class GetAllCalculatedAssetsConsolidationsSubAction extends SubAction
{
    public function run(int $memberId): Collection
    {
        /** @var EloquentCollection $assetsConsolidations */
        $assetsConsolidations = app(GetAllAssetsConsolidationsTask::class)
            ->filterByMember($memberId)
            ->addRequestCriteria()
            ->withTable()
            ->orderById()
            ->run();

        return app(CalculateAssetsConsolidationsTask::class)->run($assetsConsolidations);
    }
}

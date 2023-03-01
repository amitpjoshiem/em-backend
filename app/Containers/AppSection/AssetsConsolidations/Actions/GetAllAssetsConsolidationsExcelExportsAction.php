<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Actions;

use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\GetAllAssetsConsolidationsExcelExportTransporter;
use App\Containers\AppSection\AssetsConsolidations\Tasks\GetAllAssetsConsolidationsExportsTask;
use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetAllAssetsConsolidationsExcelExportsAction extends Action
{
    /**
     * @psalm-return LengthAwarePaginator|Collection
     */
    public function run(GetAllAssetsConsolidationsExcelExportTransporter $input): LengthAwarePaginator|Collection
    {
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        return app(GetAllAssetsConsolidationsExportsTask::class)
            ->addRequestCriteria()
            ->filterByUser($user->getKey())
            ->filterByMember($input->member_id)
            ->withMember()
            ->withMedia()
            ->run();
    }
}

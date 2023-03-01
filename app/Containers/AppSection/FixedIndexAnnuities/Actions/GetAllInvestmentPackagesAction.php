<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Actions;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters\GetAllInvestmentPackagesTransporter;
use App\Containers\AppSection\FixedIndexAnnuities\Tasks\GetAllInvestmentPackagesTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetAllInvestmentPackagesAction extends Action
{
    public function run(GetAllInvestmentPackagesTransporter $data): Collection | LengthAwarePaginator
    {
        return app(GetAllInvestmentPackagesTask::class)
            ->filterByFixedIndexAnnuities($data->fixed_index_annuities_id)
            ->withMedia()
            ->addRequestCriteria()
            ->run();
    }
}

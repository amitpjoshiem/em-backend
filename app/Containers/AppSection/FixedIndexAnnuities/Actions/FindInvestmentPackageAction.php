<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Actions;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters\FindInvestmentPackageTransporter;
use App\Containers\AppSection\FixedIndexAnnuities\Models\InvestmentPackage;
use App\Containers\AppSection\FixedIndexAnnuities\Tasks\FindInvestmentPackageTask;
use App\Ship\Parents\Actions\Action;

class FindInvestmentPackageAction extends Action
{
    public function run(FindInvestmentPackageTransporter $data): InvestmentPackage
    {
        return app(FindInvestmentPackageTask::class)->run($data->id);
    }
}

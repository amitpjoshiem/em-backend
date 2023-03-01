<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Actions;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters\DeleteInvestmentPackageTransporter;
use App\Containers\AppSection\FixedIndexAnnuities\Tasks\DeleteInvestmentPackageTask;
use App\Ship\Parents\Actions\Action;

class DeleteInvestmentPackageAction extends Action
{
    public function run(DeleteInvestmentPackageTransporter $data): void
    {
        app(DeleteInvestmentPackageTask::class)->run($data->id);
    }
}

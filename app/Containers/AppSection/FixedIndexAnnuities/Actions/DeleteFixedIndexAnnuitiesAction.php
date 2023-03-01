<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Actions;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters\DeleteFixedIndexAnnuitiesTransporter;
use App\Containers\AppSection\FixedIndexAnnuities\Tasks\DeleteFixedIndexAnnuitiesTask;
use App\Ship\Parents\Actions\Action;

class DeleteFixedIndexAnnuitiesAction extends Action
{
    public function run(DeleteFixedIndexAnnuitiesTransporter $fixedindexannuitiesData): bool
    {
        return app(DeleteFixedIndexAnnuitiesTask::class)->run($fixedindexannuitiesData->id);
    }
}

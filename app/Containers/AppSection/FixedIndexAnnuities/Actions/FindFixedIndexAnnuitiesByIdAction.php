<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Actions;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters\FindFixedIndexAnnuitiesByIdTransporter;
use App\Containers\AppSection\FixedIndexAnnuities\Models\FixedIndexAnnuities;
use App\Containers\AppSection\FixedIndexAnnuities\Tasks\FindFixedIndexAnnuitiesByIdTask;
use App\Ship\Parents\Actions\Action;

class FindFixedIndexAnnuitiesByIdAction extends Action
{
    public function run(FindFixedIndexAnnuitiesByIdTransporter $fixedindexannuitiesData): ?FixedIndexAnnuities
    {
        return app(FindFixedIndexAnnuitiesByIdTask::class)->run($fixedindexannuitiesData->id);
    }
}

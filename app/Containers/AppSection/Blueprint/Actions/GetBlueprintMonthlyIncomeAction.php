<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Actions;

use App\Containers\AppSection\Blueprint\Data\Transporters\GetBlueprintMonthlyIncomeTransporter;
use App\Containers\AppSection\Blueprint\Data\Transporters\OutputBlueprintMonthlyIncomeTransporter;
use App\Ship\Parents\Actions\Action;

class GetBlueprintMonthlyIncomeAction extends Action
{
    public function run(GetBlueprintMonthlyIncomeTransporter $blueprintData): OutputBlueprintMonthlyIncomeTransporter
    {
        return app(GetBlueprintMonthlyIncomeSubAction::class)->run($blueprintData->member_id);
    }
}

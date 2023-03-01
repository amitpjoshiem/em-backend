<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Actions;

use App\Containers\AppSection\Blueprint\Data\Transporters\OutputBlueprintMonthlyIncomeTransporter;
use App\Containers\AppSection\Blueprint\Data\Transporters\SaveBlueprintMonthlyIncomeTransporter;
use App\Containers\AppSection\Blueprint\Tasks\CalculateBlueprintMonthlyIncomeTask;
use App\Containers\AppSection\Blueprint\Tasks\SaveBlueprintMonthlyIncomeTask;
use App\Ship\Parents\Actions\Action;

class SaveBlueprintMonthlyIncomeAction extends Action
{
    public function run(SaveBlueprintMonthlyIncomeTransporter $blueprintData): OutputBlueprintMonthlyIncomeTransporter
    {
        $monthlyIncome = app(SaveBlueprintMonthlyIncomeTask::class)->run($blueprintData);

        return app(CalculateBlueprintMonthlyIncomeTask::class)->run($monthlyIncome);
    }
}

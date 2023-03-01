<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Actions;

use App\Containers\AppSection\Blueprint\Data\Transporters\OutputBlueprintMonthlyIncomeTransporter;
use App\Containers\AppSection\Blueprint\Data\Transporters\SaveBlueprintMonthlyIncomeTransporter;
use App\Containers\AppSection\Blueprint\Tasks\CalculateBlueprintMonthlyIncomeTask;
use App\Containers\AppSection\Blueprint\Tasks\GetBlueprintMonthlyIncomeByMemberIdTask;
use App\Containers\AppSection\Blueprint\Tasks\SaveBlueprintMonthlyIncomeTask;
use App\Ship\Parents\Actions\SubAction;

class GetBlueprintMonthlyIncomeSubAction extends SubAction
{
    public function run(int $memberId): OutputBlueprintMonthlyIncomeTransporter
    {
        $monthlyIncome = app(GetBlueprintMonthlyIncomeByMemberIdTask::class)->run($memberId);

        if ($monthlyIncome === null) {
            $data          = new SaveBlueprintMonthlyIncomeTransporter(['member_id' => $memberId]);
            $monthlyIncome = app(SaveBlueprintMonthlyIncomeTask::class)->run($data);
        }

        return app(CalculateBlueprintMonthlyIncomeTask::class)->run($monthlyIncome);
    }
}

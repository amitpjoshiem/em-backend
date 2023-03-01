<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Actions;

use App\Containers\AppSection\Blueprint\Data\Transporters\SaveBlueprintConcernTransporter;
use App\Containers\AppSection\Blueprint\Models\BlueprintConcern;
use App\Containers\AppSection\Blueprint\Tasks\GetBlueprintConcernByMemberIdTask;
use App\Containers\AppSection\Blueprint\Tasks\SaveBlueprintConcernTask;
use App\Ship\Parents\Actions\Action;

class GetBlueprintConcernSubAction extends Action
{
    public function run(int $memberId): BlueprintConcern
    {
        $monthlyIncome = app(GetBlueprintConcernByMemberIdTask::class)->run($memberId);

        if ($monthlyIncome === null) {
            $data          = new SaveBlueprintConcernTransporter(['member_id' => $memberId]);
            $monthlyIncome = app(SaveBlueprintConcernTask::class)->run($data);
        }

        return $monthlyIncome;
    }
}

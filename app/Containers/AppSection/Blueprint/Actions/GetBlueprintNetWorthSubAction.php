<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Actions;

use App\Containers\AppSection\Blueprint\Data\Transporters\SaveBlueprintNetWorthTransporter;
use App\Containers\AppSection\Blueprint\Models\BlueprintNetworth;
use App\Containers\AppSection\Blueprint\Tasks\GetBlueprintNetWorthByMemberIdTask;
use App\Containers\AppSection\Blueprint\Tasks\SaveBlueprintNetWorthTask;
use App\Ship\Parents\Actions\Action;

class GetBlueprintNetWorthSubAction extends Action
{
    public function run(int $memberId): BlueprintNetworth
    {
        $netWorth = app(GetBlueprintNetWorthByMemberIdTask::class)->run($memberId);

        if ($netWorth === null) {
            $data          = new SaveBlueprintNetWorthTransporter(['member_id' => $memberId]);
            $netWorth      = app(SaveBlueprintNetWorthTask::class)->run($data);
        }

        return $netWorth;
    }
}

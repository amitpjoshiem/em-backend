<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Actions;

use App\Containers\AppSection\Blueprint\Data\Transporters\SaveBlueprintNetWorthTransporter;
use App\Containers\AppSection\Blueprint\Models\BlueprintNetWorth;
use App\Containers\AppSection\Blueprint\Tasks\SaveBlueprintNetWorthTask;
use App\Ship\Parents\Actions\Action;

class SaveBlueprintNetWorthAction extends Action
{
    public function run(SaveBlueprintNetWorthTransporter $blueprintData): BlueprintNetWorth
    {
        return app(SaveBlueprintNetWorthTask::class)->run($blueprintData);
    }
}

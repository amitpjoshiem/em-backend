<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Actions;

use App\Containers\AppSection\Blueprint\Data\Transporters\GetBlueprintNetWorthTransporter;
use App\Containers\AppSection\Blueprint\Models\BlueprintNetworth;
use App\Ship\Parents\Actions\Action;

class GetBlueprintNetWorthAction extends Action
{
    public function run(GetBlueprintNetWorthTransporter $blueprintData): BlueprintNetworth
    {
        return app(GetBlueprintNetWorthSubAction::class)->run($blueprintData->member_id);
    }
}

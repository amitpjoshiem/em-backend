<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Actions;

use App\Containers\AppSection\Blueprint\Data\Transporters\GetBlueprintConcernTransporter;
use App\Containers\AppSection\Blueprint\Models\BlueprintConcern;
use App\Ship\Parents\Actions\Action;

class GetBlueprintConcernAction extends Action
{
    public function run(GetBlueprintConcernTransporter $blueprintData): BlueprintConcern
    {
        return app(GetBlueprintConcernSubAction::class)->run($blueprintData->member_id);
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Actions;

use App\Containers\AppSection\Blueprint\Data\Transporters\SaveBlueprintConcernTransporter;
use App\Containers\AppSection\Blueprint\Models\BlueprintConcern;
use App\Containers\AppSection\Blueprint\Tasks\SaveBlueprintConcernTask;
use App\Ship\Parents\Actions\Action;

class SaveBlueprintConcernAction extends Action
{
    public function run(SaveBlueprintConcernTransporter $blueprintData): BlueprintConcern
    {
        return app(SaveBlueprintConcernTask::class)->run($blueprintData);
    }
}

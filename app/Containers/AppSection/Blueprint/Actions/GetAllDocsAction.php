<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Actions;

use App\Containers\AppSection\Blueprint\Data\Transporters\GetAllBlueprintDocsTransporter;
use App\Containers\AppSection\Blueprint\Tasks\FindAllBlueprintDocByMemberIdTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

class GetAllDocsAction extends Action
{
    public function run(GetAllBlueprintDocsTransporter $input): Collection
    {
        return app(FindAllBlueprintDocByMemberIdTask::class)
            ->addRequestCriteria()
            ->withMedia()
            ->run($input->member_id);
    }
}

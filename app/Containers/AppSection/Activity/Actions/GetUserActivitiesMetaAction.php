<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\Actions;

use App\Containers\AppSection\Activity\Tasks\GetAllActivitiesTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class GetUserActivitiesMetaAction extends Action
{
    public function run(Collection $activities): array
    {
        /** @var Collection $total */
        $total = app(GetAllActivitiesTask::class)->run();

        return [
            'current' => $activities->count(),
            'total'   => $total->count(),
        ];
    }
}

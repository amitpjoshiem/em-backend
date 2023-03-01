<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\UI\API\Controllers;

use App\Containers\AppSection\Activity\Actions\GetUserActivitiesAction;
use App\Containers\AppSection\Activity\UI\API\Transformers\ActivityTransformer;
use App\Ship\Parents\Controllers\ApiController;

class Controller extends ApiController
{
    public function getUserActivities(): array
    {
        $activities = app(GetUserActivitiesAction::class)->run();

        return $this->transform($activities, new ActivityTransformer(), resourceKey: 'day');
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\UI\API\Transformers;

use App\Containers\AppSection\Activity\Events\Events\AbstractActivityEvent;
use App\Containers\AppSection\Activity\Models\UserActivity;
use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Item;

class ActivityTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'user',
    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(UserActivity $activity): array
    {
        /** @var AbstractActivityEvent $activityClass */
        $activityClass = $activity->activity;

        return [
            'content'       => $activityClass::getActivityHtmlString($activity->activity_data),
            'time'          => $activity->created_at->toTimeString(),
            'date'          => $activity->created_at->toDateString(),
        ];
    }

    public function includeUser(UserActivity $activity): Item
    {
        return $this->item($activity->user, new UserTransformer());
    }
}

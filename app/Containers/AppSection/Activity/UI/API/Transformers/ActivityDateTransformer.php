<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\UI\API\Transformers;

use App\Containers\AppSection\Activity\Models\UserActivity;
use App\Ship\Parents\Transformers\Transformer;
use Illuminate\Database\Eloquent\Collection;
use League\Fractal\Resource\Collection as FractalCollection;

class ActivityDateTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'events',
    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(Collection $activityDays): array
    {
        /** @var UserActivity $event */
        $event = $activityDays->first();

        return [
            'day' => $event->created_at->format('Y-m-d'),
        ];
    }

    public function includeEvents(Collection $activityDays): FractalCollection
    {
        return $this->collection($activityDays, new ActivityTransformer(), resourceKey: 'events');
    }
}

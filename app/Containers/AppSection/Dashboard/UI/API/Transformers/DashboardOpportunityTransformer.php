<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Dashboard\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Collection;

class DashboardOpportunityTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'values',
    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(object $data): array
    {
        return [
            'total'    => $data->total,
            'percent'  => $data->total === null ? 0 : abs($data->percent) * 100,
            'up'       => $data->total === null ? null : $data->percent >= 0,
        ];
    }

    public function includeValues(object $data): Collection
    {
        return $this->collection($data->values, new DashboardOpportunityValuesTransformer(), 'values');
    }
}

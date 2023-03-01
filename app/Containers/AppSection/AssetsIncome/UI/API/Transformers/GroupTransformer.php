<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\UI\API\Transformers;

use App\Containers\AppSection\AssetsIncome\Data\Schemas\GroupSchema;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Collection;

class GroupTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'rows',
    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(GroupSchema $group): array
    {
        return [
            'title'   => $group->title,
            'name'    => $group->name,
            'headers' => $group->headers,
        ];
    }

    public function includeRows(GroupSchema $group): Collection
    {
        return $this->collection($group->rows, new RowTransformer(), resourceKey: 'rows');
    }
}

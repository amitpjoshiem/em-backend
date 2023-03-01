<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\UI\API\Transformers;

use App\Containers\AppSection\AssetsIncome\Data\Schemas\RowSchema;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Collection;

class RowTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'elements',
    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(RowSchema $row): array
    {
        return [
            'label'     => $row->label,
            'name'      => $row->name,
            'custom'    => $row->custom,
            'joined'    => $row->joined,
            'can_join'  => $row->getCanJoin(),
        ];
    }

    public function includeElements(RowSchema $row): Collection
    {
        return $this->collection($row->elements, new ElementTransformer(), resourceKey: 'column');
    }
}

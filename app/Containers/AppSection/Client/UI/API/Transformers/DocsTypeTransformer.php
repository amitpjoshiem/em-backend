<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\UI\API\Transformers;

use App\Containers\AppSection\Client\Data\Enums\ClientDocumentsTypesEnum;
use App\Ship\Parents\Transformers\Transformer;

class DocsTypeTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [

    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(string $type): array
    {
        return [
            'value' => $type,
            'label' => ClientDocumentsTypesEnum::getLabel($type),
        ];
    }
}

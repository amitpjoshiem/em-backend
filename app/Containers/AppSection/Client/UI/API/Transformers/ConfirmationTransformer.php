<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\UI\API\Transformers;

use App\Containers\AppSection\Client\Models\ClientConfirmation;
use App\Ship\Parents\Transformers\Transformer;

class ConfirmationTransformer extends Transformer
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

    public function transform(ClientConfirmation $data): array
    {
        return [
            $data->item => $data->value,
        ];
    }
}

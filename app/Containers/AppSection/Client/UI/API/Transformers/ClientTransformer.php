<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\UI\API\Transformers;

use App\Containers\AppSection\Client\Data\Enums\ClientDocumentsEnum;
use App\Containers\AppSection\Client\Models\Client;
use App\Ship\Parents\Transformers\Transformer;

class ClientTransformer extends Transformer
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

    public function transform(Client $client): array
    {
        $steps = [];
        foreach (ClientDocumentsEnum::values() as $step) {
            $steps[$step] = $client->{$step} !== Client::NOT_COMPLETED_STEP;
        }

        return $steps;
    }
}

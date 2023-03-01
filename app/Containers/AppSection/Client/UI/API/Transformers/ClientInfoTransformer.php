<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\UI\API\Transformers;

use App\Containers\AppSection\Client\Data\Transporters\OutputClientInfoTransporter;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Item;

class ClientInfoTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'steps',
    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(OutputClientInfoTransporter $data): array
    {
        return [
            'name'                 => $data->member->name,
            'type'                 => $data->member->type,
            'member_id'            => $data->member->getHashedKey(),
            'terms_and_conditions' => $data->client->terms_and_conditions,
            'readonly'             => $data->client->readonly,
        ];
    }

    public function includeSteps(OutputClientInfoTransporter $data): Item
    {
        return $this->item($data->client, new ClientTransformer());
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Settings\UI\API\Transformers;

use App\Containers\AppSection\Settings\Models\Setting;
use App\Ship\Parents\Transformers\Transformer;

class SettingTransformer extends Transformer
{
    public function transform(Setting $entity): array
    {
        $response = [

            'object' => 'Setting',
            'id'     => $entity->getHashedKey(),

            'key'   => $entity->key,
            'value' => $entity->value,
        ];

        return $this->ifAdmin([
            'real_id' => $entity->id,
        ], $response);
    }
}

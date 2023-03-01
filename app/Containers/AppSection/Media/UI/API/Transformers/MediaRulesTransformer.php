<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\UI\API\Transformers;

use App\Containers\AppSection\Media\Data\Transporters\GetCollectionMediaRulesOutputTransporter;
use App\Ship\Parents\Transformers\Transformer;

class MediaRulesTransformer extends Transformer
{
    public function transform(GetCollectionMediaRulesOutputTransporter $rules): array
    {
        return [
            'size'          => $rules->size,
            'allowed_types' => $rules->allowed_types,
        ];
    }
}

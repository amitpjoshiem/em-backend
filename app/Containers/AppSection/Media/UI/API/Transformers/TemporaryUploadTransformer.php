<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\UI\API\Transformers;

use App\Containers\AppSection\Media\Models\TemporaryUpload;
use App\Containers\AppSection\Media\Traits\IncludeMediaModelsTransformerTrait;
use App\Containers\AppSection\Media\Traits\IncludeMediaModelTransformerTrait;
use App\Ship\Parents\Transformers\Transformer;

class TemporaryUploadTransformer extends Transformer
{
    use IncludeMediaModelsTransformerTrait;
    use IncludeMediaModelTransformerTrait;

    /**
     * @var array<string>
     */
    protected $availableIncludes = [
        'media',
        'medias',
    ];

    public function __construct()
    {
        $this->withMediaExpiration = true;
    }

    public function transform(TemporaryUpload $entity): array
    {
        return [
            'object' => $entity->getResourceKey(),
            'id'     => $entity->getHashedKey(),
            'uuid'   => $entity->uuid,
        ];
    }
}

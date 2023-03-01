<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Traits;

use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Media\Tasks\GetAllMediaByModelTask;
use App\Containers\AppSection\Media\UI\API\Transformers\MediaTransformer;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Collection;

/**
 * Trait IncludeMediaModelsTransformerTrait.
 *
 * @mixin Transformer
 */
trait IncludeMediaModelsTransformerTrait
{
    public bool $withMediaExpiration = false;

    public string $unit = 'hour';

    public int $value = 1;

    /**
     * This method provide transformed `Media` Collection from entity.
     */
    public function includeMedias(HasInteractsWithMedia $entity): Collection
    {
        $media = app(GetAllMediaByModelTask::class)->run($entity, $entity->getCollection());

        return $this->collection($media, new MediaTransformer($this->withMediaExpiration, $this->unit, $this->value));
    }
}

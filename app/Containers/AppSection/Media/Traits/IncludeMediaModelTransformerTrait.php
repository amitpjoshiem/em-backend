<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Traits;

use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Media\Tasks\FindMediaByModelTask;
use App\Containers\AppSection\Media\UI\API\Transformers\MediaTransformer;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\NullResource;

/**
 * Trait IncludeMediaModelTransformerTrait.
 *
 * @mixin Transformer
 */
trait IncludeMediaModelTransformerTrait
{
    public bool $withMediaExpiration = false;

    public string $unit = 'hour';

    public int $value = 1;

    /**
     * This method provide transformed `Media` object from entity.
     */
    public function includeMedia(HasInteractsWithMedia $entity): Item | NullResource
    {
        try {
            $media = app(FindMediaByModelTask::class)->run($entity, $entity->getCollection());
        } catch (NotFoundException) {
            return $this->null();
        }

        return $this->item($media, new MediaTransformer($this->withMediaExpiration, $this->unit, $this->value));
    }
}

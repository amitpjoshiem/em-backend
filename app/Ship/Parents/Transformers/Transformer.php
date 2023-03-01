<?php

namespace App\Ship\Parents\Transformers;

use App\Containers\AppSection\EntityLogger\Traits\EntityLoggerTransformerTrait;
use App\Containers\AppSection\Media\Models\Media;
use App\Ship\Core\Abstracts\Exceptions\Exception;
use App\Ship\Core\Abstracts\Transformers\Transformer as AbstractTransformer;
use Carbon\Carbon;

abstract class Transformer extends AbstractTransformer
{
    use EntityLoggerTransformerTrait;

    protected function getUrl(Media $entity, Carbon $linkExpire): string
    {
        try {
            return $entity->getTemporaryUrl($linkExpire);
            // phpcs:disable
        } catch (Exception) {
            // phpcs:enable
            return $entity->getFullUrl();
        }
    }
}

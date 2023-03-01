<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Tasks;

use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FindMediaByModelTask extends Task
{
    public function run(HasInteractsWithMedia $model, string $collectionName = MediaCollectionEnum::DEFAULT, array | callable $filters = []): Media
    {
        $media = $model->getFirstMedia($collectionName, $filters);

        if ($media === null) {
            throw new NotFoundException();
        }

        return $media;
    }
}

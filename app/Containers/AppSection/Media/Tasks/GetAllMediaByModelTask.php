<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Tasks;

use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class GetAllMediaByModelTask extends Task
{
    public function run(HasInteractsWithMedia $model, string $collectionName = MediaCollectionEnum::DEFAULT, array | callable $filters = []): Collection
    {
        return $model->getMedia($collectionName, $filters);
    }
}

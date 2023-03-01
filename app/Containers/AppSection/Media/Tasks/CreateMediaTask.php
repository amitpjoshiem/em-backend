<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Tasks;

use App\Containers\AppSection\Media\Data\Transporters\CreateMediaByOneFileTransporter;
use App\Ship\Parents\Tasks\Task;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CreateMediaTask extends Task
{
    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function run(CreateMediaByOneFileTransporter $mediaData): Media
    {
        return $mediaData->model
            ->addMedia($mediaData->file)
            ->toMediaCollection($mediaData->collection);
    }
}

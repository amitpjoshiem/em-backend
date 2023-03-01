<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Services;

use App\Containers\AppSection\Media\Exceptions\UnacceptableFile;
use App\Containers\AppSection\Media\Exceptions\UnacceptableFileType;
use Spatie\MediaLibrary\MediaCollections\File as PendingFile;
use Spatie\MediaLibrary\MediaCollections\FileAdder as BaseFileAdder;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Class FileAdder.
 */
class FileAdder extends BaseFileAdder
{
    protected function guardAgainstDisallowedFileAdditions(Media $media): void
    {
        $file = PendingFile::createFromMedia($media);

        if (($collection = $this->getMediaCollection($media->collection_name)) === null) {
            return;
        }

        if (! ($collection->acceptsFile)($file, $this->subject)) {
            throw  new UnacceptableFile();
        }

        if (! empty($collection->acceptsMimeTypes) && ! \in_array($file->mimeType, $collection->acceptsMimeTypes, true)) {
            throw new UnacceptableFileType();
        }
    }
}

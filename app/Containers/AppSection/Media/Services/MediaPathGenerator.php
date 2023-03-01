<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Services;

use Illuminate\Foundation\Application;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

final class MediaPathGenerator implements PathGenerator
{
    private string $envPath;

    public function __construct(private Application $app)
    {
        $this->envPath = (string)$this->app->environment();
    }

    /**
     * Get the path for the given media, relative to the root storage path.
     */
    public function getPath(Media $media): string
    {
        return $this->getBasePath($media) . '/';
    }

    /**
     * Get the path for conversions of the given media, relative to the root storage path.
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getBasePath($media) . '/conversions/';
    }

    /**
     * Get the path for responsive images of the given media, relative to the root storage path.
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getBasePath($media) . '/responsive-images/';
    }

    /**
     * Get a unique base path for the given media.
     */
    protected function getBasePath(Media $media): string
    {
        return sprintf('%s/%s/%s', $this->envPath, $media->collection_name, $media->getKey());
    }
}

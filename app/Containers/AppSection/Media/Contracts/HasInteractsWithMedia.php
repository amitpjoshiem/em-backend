<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Contracts;

use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

interface HasInteractsWithMedia extends HasMedia
{
    public function getMediaCollection(string $collectionName = MediaCollectionEnum::DEFAULT): ?MediaCollection;

    public function getFirstMedia(string $collectionName = MediaCollectionEnum::DEFAULT, array|callable $filters = []): ?Media;

    /**
     * Get the value of the model's primary key.
     *
     * @psalm-return mixed
     */
    public function getKey();

    /**
     * Get the class name for polymorphic relations.
     *
     * @return string
     */
    public function getMorphClass();

    /**
     * Get the value of the model's primary key.
     */
    public function getAuthorId(): ?int;

    /**
     * Get the value of the model's primary key.
     */
    public function getCollection(): string;

    /**
     * Reload the current model instance with fresh attributes from the database.
     *
     * @return $this
     */
    public function refresh();
}

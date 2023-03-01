<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Traits;

use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Traits\InteractsWithMedia;
use App\Containers\AppSection\User\Tasks\GetCacheAvatarKeyTask;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasUserAvatar
{
    use InteractsWithMedia;

    private ?string $avatarUrlAccessorAttribute = null;

    public function getCollection(): string
    {
        return MediaCollectionEnum::AVATAR;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(MediaCollectionEnum::AVATAR)
            ->useFallbackUrl($this->defaultAvatarUrl())
            ->singleFile();
    }

    /**
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->performOnCollections(MediaCollectionEnum::AVATAR)
            ->width(150);
    }

    /**
     * Get the default avatar URL if no avatar has been uploaded.
     */
    protected function defaultAvatarUrl(): string
    {
        return sprintf('https://www.gravatar.com/avatar/%s.jpg?s=150&d=mm', $this->getAvatarSlug());
    }

    protected function getAvatarSlug(): string
    {
        return md5(Str::lower($this->getTable() . $this->getHashedKey()));
    }

    // Accessors

    /**
     * Get the URL to the user's avatar.
     *
     * @uses User::$avatar_url
     */
    public function getAvatarUrlAttribute(): string
    {
        return Cache::remember(
            app(GetCacheAvatarKeyTask::class)->run($this->getKey()),
            60,
            fn (): string => $this->getFirstMediaUrl(MediaCollectionEnum::AVATAR)
        );
    }
}

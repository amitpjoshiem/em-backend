<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Models;

use App\Containers\AppSection\Authentication\Tasks\GetAuthenticatedUserTask;
use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Media\Traits\InteractsWithMedia;
use App\Ship\Parents\Models\Model;
use App\Ship\Parents\Traits\EagerLoadPivotBuilder;
use Eloquent;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

/**
 * Class TemporaryUpload.
 *
 * @property      int                             $id
 * @property      string                          $uuid
 * @property      string                          $collection
 * @property      \Illuminate\Support\Carbon|null $created_at
 * @property      \Illuminate\Support\Carbon|null $updated_at
 * @property-read MediaCollection|Media[]         $media
 * @property-read int|null                        $media_count
 *
 * @method static EagerLoadPivotBuilder|TemporaryUpload newModelQuery()
 * @method static EagerLoadPivotBuilder|TemporaryUpload newQuery()
 * @method static EagerLoadPivotBuilder|TemporaryUpload query()
 * @method static EagerLoadPivotBuilder|TemporaryUpload whereCollection($value)
 * @method static EagerLoadPivotBuilder|TemporaryUpload whereCreatedAt($value)
 * @method static EagerLoadPivotBuilder|TemporaryUpload whereId($value)
 * @method static EagerLoadPivotBuilder|TemporaryUpload whereUpdatedAt($value)
 * @method static EagerLoadPivotBuilder|TemporaryUpload whereUuid($value)
 * @mixin Eloquent
 */
class TemporaryUpload extends Model implements HasInteractsWithMedia
{
    use InteractsWithMedia;

    protected static bool $useLogger = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'collection',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * A resource key to be used by the the JSON API Serializer responses.
     */
    protected string $resourceKey = 'TemporaryUpload';

    /**
     * @inheritDoc
     */
    public function getAuthorId(): ?int
    {
        $authUser = app(GetAuthenticatedUserTask::class)->run();

        return $authUser?->getAuthIdentifier();
    }

    public function getCollection(): string
    {
        return $this->collection;
    }
}

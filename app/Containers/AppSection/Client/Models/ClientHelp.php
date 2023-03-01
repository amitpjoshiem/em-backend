<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Models;

use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Traits\InteractsWithMedia;
use App\Ship\Parents\Models\Model;

/**
 * @property int    $id
 * @property string $type
 * @property string $text
 */
class ClientHelp extends Model implements HasInteractsWithMedia
{
    use InteractsWithMedia;

    /**
     * @var string
     */
    protected $table = 'client_help';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'type',
        'text',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
    ];

    /**
     * @var array<string>
     */
    protected $hidden = [

    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'ClientHelp';

    public function getAuthorId(): ?int
    {
        return null;
    }

    public function getCollection(): string
    {
        return MediaCollectionEnum::CLIENT_HELP;
    }
}

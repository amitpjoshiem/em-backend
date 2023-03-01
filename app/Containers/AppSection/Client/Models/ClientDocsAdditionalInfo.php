<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Models;

use App\Containers\AppSection\Media\Models\Media;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int                        $id
 * @property string                     $name
 * @property string|null                $description
 * @property string|null                $type
 * @property bool                       $is_spouse
 * @property Client                     $client
 * @property Media                      $media
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class ClientDocsAdditionalInfo extends Model
{
    /**
     * @var string
     */
    protected $table = 'client_docs_additional_info';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
        'client_id',
        'type',
        'media_id',
        'is_spouse',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_spouse' => false,
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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_spouse'  => 'bool',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'ClientDocsAdditionalInfo';

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}

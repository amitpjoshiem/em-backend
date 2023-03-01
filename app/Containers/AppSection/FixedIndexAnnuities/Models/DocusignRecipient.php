<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Models;

use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int                $id
 * @property RecipientInterface $recipient
 */
class DocusignRecipient extends Model
{
    protected static bool $useLogger = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'recipient_type',
        'recipient_id',
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
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'DocusignRecipient';

    public function recipient(): MorphTo
    {
        return $this->morphTo();
    }
}

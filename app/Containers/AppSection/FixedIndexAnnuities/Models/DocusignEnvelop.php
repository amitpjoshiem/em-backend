<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Models;

use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int               $id
 * @property DocumentInterface $document
 * @property DocusignRecipient $advisorRecipient
 * @property DocusignRecipient $clientRecipient
 */
class DocusignEnvelop extends Model
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
        'document_type',
        'document_id',
        'advisor_recipient_id',
        'client_recipient_id',
        'envelop_id',
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
    protected string $resourceKey = 'DocusignEnvelop';

    public function document(): MorphTo
    {
        return $this->morphTo();
    }

    public function advisorRecipient(): BelongsTo
    {
        return $this->belongsTo(DocusignRecipient::class, 'advisor_recipient_id');
    }

    public function clientRecipient(): BelongsTo
    {
        return $this->belongsTo(DocusignRecipient::class, 'client_recipient_id');
    }
}

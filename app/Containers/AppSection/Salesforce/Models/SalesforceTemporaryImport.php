<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Models;

use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int                   $id
 * @property string                $owner_id
 * @property string                $salesforce_id
 * @property string                $object
 * @property SalesforceUser | null $salesforceUser
 */
class SalesforceTemporaryImport extends Model
{
    protected static bool $useLogger = false;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'owner_id',
        'salesforce_id',
        'object',
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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'SalesforceTemporaryImport';

    public function salesforceUser(): BelongsTo
    {
        return $this->belongsTo(SalesforceUser::class, 'owner_id', 'salesforce_id');
    }
}

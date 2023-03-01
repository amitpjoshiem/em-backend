<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Models;

use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class SalesforceUser.
 *
 * @property int                       $id
 * @property int                       $object_id
 * @property string                    $object_class
 * @property string                    $action
 * @property array | null              $data
 * @property SalesforceObjectInterface $salesforceObject
 */
class SalesforceTemporaryExport extends Model
{
    protected static bool $useLogger = false;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'object_id',
        'object_class',
        'data',
        'action',
        'updated_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'created_at'      => 'datetime',
        'updated_at'      => 'datetime',
        'data'            => 'json',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'SalesforceTemporaryExport';

    public function salesforceObject(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'object_class', 'object_id');
    }
}

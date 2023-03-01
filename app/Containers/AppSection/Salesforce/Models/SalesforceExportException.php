<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Models;

use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int                              $id
 * @property SalesforceObjectInterface | null $salesforceObject
 * @property array                            $request
 * @property array                            $response
 * @property string                           $method
 * @property string                           $trace
 * @property string                           $object_type
 * @property string                           $url
 * @property \Carbon\Carbon                   $created_at
 * @property \Carbon\Carbon                   $updated_at
 */
class SalesforceExportException extends Model
{
    protected static bool $useLogger = false;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'object_type',
        'object_id',
        'request',
        'response',
        'method',
        'trace',
        'url',
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
        'created_at'      => 'datetime',
        'updated_at'      => 'datetime',
        'request'         => 'json',
        'response'        => 'json',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'SalesforceExportException';

    public function salesforceObject(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'object_type', 'object_id');
    }

    public function getObjectName(): string
    {
        $path = explode('\\', $this->object_type);

        return array_pop($path);
    }
}

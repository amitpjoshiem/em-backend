<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Models;

use App\Ship\Parents\Models\Model;

/**
 * @property int            $id
 * @property string         $object
 * @property string         $salesforce_id
 * @property array          $salesforce_data
 * @property string         $trace
 * @property string         $message
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class SalesforceImportException extends Model
{
    protected static bool $useLogger = false;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'salesforce_id',
        'object',
        'salesforce_data',
        'trace',
        'message',
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
        'created_at'           => 'datetime',
        'updated_at'           => 'datetime',
        'salesforce_data'      => 'array',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'SalesforceImportException';

    public function getObjectName(): string
    {
        $path = explode('\\', $this->object);

        return array_pop($path);
    }
}

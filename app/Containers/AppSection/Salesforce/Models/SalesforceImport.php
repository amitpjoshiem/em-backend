<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Models;

use App\Ship\Parents\Models\Model;

/**
 * @property int                     $id
 * @property \Carbon\CarbonImmutable $start_date
 * @property \Carbon\CarbonImmutable $end_date
 * @property string                  $object
 */
class SalesforceImport extends Model
{
    protected static bool $useLogger = false;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'start_date',
        'end_date',
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
        'start_date'    => 'immutable_datetime',
        'end_date'      => 'immutable_datetime',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'SalesforceImport';

    public function getObjectName(): string
    {
        $path = explode('\\', $this->object);

        return array_pop($path);
    }
}

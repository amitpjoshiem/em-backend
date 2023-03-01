<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Models;

use App\Ship\Parents\Models\Model;

/**
 * Class SalesforceUser.
 *
 * @property int    $user_id
 * @property string $salesforce_id
 */
class SalesforceUser extends Model
{
    protected static bool $useLogger = false;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'salesforce_id',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'SalesforceUser';
}

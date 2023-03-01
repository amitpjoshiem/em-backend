<?php

declare(strict_types=1);

namespace App\Containers\AppSection\EntityLogger\Models;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int            $id
 * @property string         $action
 * @property int            $loggable_id
 * @property string         $loggable_type
 * @property array | null   $before
 * @property array | null   $after
 * @property \Carbon\Carbon $created_at
 * @property User | null    $user
 * @property Model          $entity
 */
class EntityLog extends Model
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
        'user_id',
        'loggable_id',
        'loggable_type',
        'action',
        'before',
        'after',
        'created_at',
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
        'before'     => 'json',
        'after'      => 'json',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'EntityLog';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

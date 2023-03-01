<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Models;

use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int    $id
 * @property User   $fromUser
 * @property User   $toUser
 * @property int    $from_id
 * @property int    $to_id
 * @property string $model_repository
 * @property int    $model_id
 */
class UsersTransfer extends Model
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
        'from_id',
        'to_id',
        'model_repository',
        'model_id',
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
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'UsersTransfer';

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_id');
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int                        $yodlee_id
 * @property int                        $member_id
 * @property int                        $user_id
 * @property string                     $account_name
 * @property string                     $account_status
 * @property float                      $balance
 * @property bool                       $include_int_net_worth
 * @property int                        $provider_id
 * @property string                     $provider_name
 * @property Member                     $member
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $sync_at
 */
class YodleeAccounts extends Model implements BelongToMemberInterface
{
    /**
     * @var array<string>
     */
    protected $fillable = [
        'yodlee_id',
        'member_id',
        'user_id',
        'account_name',
        'account_status',
        'balance',
        'include_int_net_worth',
        'provider_id',
        'provider_name',
        'created_at',
        'updated_at',
        'sync_at',
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
        'created_at'            => 'datetime',
        'updated_at'            => 'datetime',
        'sync_at'               => 'datetime',
        'include_int_net_worth' => 'bool',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Yodlee Account';

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

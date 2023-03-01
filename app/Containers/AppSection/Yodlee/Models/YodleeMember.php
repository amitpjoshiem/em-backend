<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Yodlee\Exceptions\BaseException;
use App\Containers\AppSection\Yodlee\Services\YodleeUserApiService;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int                             $id
 * @property int                             $member_id
 * @property int                             $yodlee_id
 * @property string                          $login_name
 * @property bool                            $link_sent
 * @property bool                            $link_used
 * @property \Illuminate\Support\Carbon|null $link_expired
 * @property \Illuminate\Support\Carbon      $created_at
 * @property \Illuminate\Support\Carbon      $updated_at
 * @property Member                          $member
 */
class YodleeMember extends Model implements BelongToMemberInterface
{
    /**
     * @var array<string>
     */
    protected $fillable = [
        'member_id',
        'yodlee_id',
        'login_name',
        'link_sent',
        'link_expired',
        'link_used',
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
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
        'link_expired'  => 'datetime',
        'link_sent'     => 'boolean',
        'link_used'     => 'boolean',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Yodlee';

    /**
     * @throws BaseException
     */
    public function api(): YodleeUserApiService
    {
        return new YodleeUserApiService($this->login_name, $this->member_id);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function isSentLinkValidStatus(): bool
    {
        return $this->link_sent && ($this->link_expired?->diff()->invert ?? false);
    }

    public function isUsedLinkValidStatus(): bool
    {
        return $this->link_used && ($this->link_expired?->diff()->invert ?? false);
    }
}

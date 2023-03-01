<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int    $id
 * @property string $group
 * @property string $item
 * @property bool   $value
 * @property Member $member
 * @property Client $client
 */
class ClientConfirmation extends Model implements BelongToMemberInterface
{
    /**
     * @var string
     */
    public const CURRENTLY_HAVE_GROUP = 'currently_have';

    /**
     * @var string
     */
    public const MORE_INFO_ABOUT_GROUP = 'more_info_about';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'member_id',
        'group',
        'item',
        'value',
        'client_id',
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
        'value' => 'boolean',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'ClientConfirmation';

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}

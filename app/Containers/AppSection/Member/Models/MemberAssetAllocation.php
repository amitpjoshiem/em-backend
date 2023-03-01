<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class MemberAssetAllocation.
 *
 * @OA\Schema (
 *     title="MemberAssetAllocation",
 *     description="MemberAssetAllocation Basic Info",
 *     required={"id"},
 *     @OA\Property (
 *          property="growth",
 *          type="float",
 *          example="99999.999"
 *     ),
 *     @OA\Property (
 *          property="income",
 *          type="float",
 *          example="99999.999"
 *     ),
 *     @OA\Property (
 *          property="liquidity",
 *          type="float",
 *          example="99999.999"
 *     ),
 * )
 *
 * @property int                        $id
 * @property float|null                 $liquidity
 * @property float|null                 $growth
 * @property float|null                 $income
 * @property Member                     $member
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class MemberAssetAllocation extends Model implements BelongToMemberInterface
{
    /**
     * @var array<string>
     */
    protected $fillable = [
        'liquidity',
        'member_id',
        'growth',
        'income',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
        'liquidity'     => 'float',
        'growth'        => 'float',
        'income'        => 'float',
    ];

    /**
     * @var array<string, float>
     */
    protected $attributes = [
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'MemberAssetAllocation';

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}

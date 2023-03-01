<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class BlueprintNetworth.
 *
 * @OA\Schema (
 *     title="BlueprintNetworth",
 *     description="Blueprint Concern Basic Info",
 *     @OA\Property (
 *          property="id",
 *          type="string",
 *          example="egrlyazq98mno3k0"
 *     ),
 *     @OA\Property (
 *          property="market",
 *          type="float",
 *          example=99999.99
 *     ),
 *     @OA\Property (
 *          property="liquid",
 *          type="float",
 *          example=99999.99
 *     ),
 *     @OA\Property (
 *          property="income_safe",
 *          type="float",
 *          example=99999.99
 *     )
 * )
 *
 * @property int                        $id
 * @property float|null                 $market
 * @property float|null                 $liquid
 * @property float|null                 $income_safe
 * @property Member                     $member
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class BlueprintNetworth extends Model implements BelongToMemberInterface
{
    /**
     * @var array<string>
     */
    protected $fillable = [
        'member_id',
        'market',
        'liquid',
        'income_safe',
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
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'market'      => 'float',
        'liquid'      => 'float',
        'income_safe' => 'float',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'BlueprintNetworth';

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}

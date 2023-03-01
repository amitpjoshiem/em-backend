<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class MemberHouse.
 *
 * @OA\Schema (
 *     title="Member House",
 *     description="Member House Info",
 *     required={"id"},
 *     @OA\Property (
 *          property="id",
 *          type="string",
 *          example="egrlyazq98mno3k0"
 *     ),
 *     @OA\Property (
 *          property="type",
 *          type="string",
 *          description="One of types (family|rent|own)",
 *          example="family"
 *     ),
 *     @OA\Property (
 *          property="market_value",
 *          type="string",
 *          example="999999.999"
 *     ),
 *     @OA\Property (
 *          property="total_debt",
 *          type="string",
 *          example="999999.999"
 *     ),
 *     @OA\Property (
 *          property="remaining_mortgage_amount",
 *          type="string",
 *          example="999999.999"
 *     ),
 *     @OA\Property (
 *          property="monthly_payment",
 *          type="string",
 *          example="999999.999"
 *     ),
 *     @OA\Property (
 *          property="total_monthly_expenses",
 *          type="string",
 *          example="999999.999"
 *     ),
 * )
 *
 * @property int    $id
 * @property int    $member_id
 * @property string $type
 * @property float  $market_value
 * @property float  $total_debt
 * @property float  $remaining_mortgage_amount
 * @property float  $monthly_payment
 * @property float  $total_monthly_expenses
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class MemberHouse extends Model implements BelongToMemberInterface
{
    /**
     * @var string
     */
    public const OWN = 'own';

    /**
     * @var string
     */
    public const RENT = 'rent';

    /**
     * @var string
     */
    public const FAMILY = 'family';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'type',
        'market_value',
        'total_debt',
        'remaining_mortgage_amount',
        'monthly_payment',
        'total_monthly_expenses',
        'member_id',
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
        'created_at'                => 'datetime',
        'updated_at'                => 'datetime',
        'market_value'              => 'float',
        'total_debt'                => 'float',
        'remaining_mortgage_amount' => 'float',
        'monthly_payment'           => 'float',
        'total_monthly_expenses'    => 'float',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'MemberHouse';

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}

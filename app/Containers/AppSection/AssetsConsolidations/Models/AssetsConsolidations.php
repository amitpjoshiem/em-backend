<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * class AssetsConsolidations.
 *
 * @OA\Schema (
 *     title="AssetsConsolidationsOutput",
 *     schema="AssetsConsolidationsOutput",
 *     description="AssetsConsolidations Basic Info",
 *     required={"id"},
 *     @OA\Property (
 *          property="id",
 *          type="string",
 *          example="egrlyazq98mno3k0"
 *     ),
 *     @OA\Property (
 *          property="name",
 *          type="string",
 *          example="Test Name"
 *     ),
 *     @OA\Property (
 *          property="percent_of_holdings",
 *          type="float",
 *          example="99.99"
 *     ),
 *     @OA\Property (
 *          property="amount",
 *          type="float",
 *          example="99999.99"
 *     ),
 *     @OA\Property (
 *          property="management_expense",
 *          type="float",
 *          example="99.99"
 *     ),
 *     @OA\Property (
 *          property="turnover",
 *          type="float",
 *          example="99.99"
 *     ),
 *     @OA\Property (
 *          property="trading_cost",
 *          type="float",
 *          example="99.99"
 *     ),
 *     @OA\Property (
 *          property="wrap_fee",
 *          type="float",
 *          example="99.99"
 *     ),
 *     @OA\Property (
 *          property="total_cost_percent",
 *          type="float",
 *          example="99.99"
 *     ),
 *     @OA\Property (
 *          property="total_cost",
 *          type="float",
 *          example="99999.99"
 *     ),
 * )
 * @OA\Schema (
 *     title="AssetsConsolidationsInput",
 *     schema="AssetsConsolidationsInput",
 *     description="AssetsConsolidations Basic Info",
 *     required={"id"},
 *     @OA\Property (
 *          property="id",
 *          type="string",
 *          example="egrlyazq98mno3k0"
 *     ),
 *     @OA\Property (
 *          property="name",
 *          type="string",
 *          example="Test Name"
 *     ),
 *     @OA\Property (
 *          property="amount",
 *          type="float",
 *          example="99999.99"
 *     ),
 *     @OA\Property (
 *          property="management_expense",
 *          type="float",
 *          example="99.99"
 *     ),
 *     @OA\Property (
 *          property="turnover",
 *          type="float",
 *          example="99.99"
 *     ),
 *     @OA\Property (
 *          property="trading_cost",
 *          type="float",
 *          example="99.99"
 *     ),
 *     @OA\Property (
 *          property="wrap_fee",
 *          type="float",
 *          example="99.99"
 *     ),
 * )
 *
 * @property int                        $id
 * @property Member                     $member
 * @property string                     $name
 * @property float                      $amount
 * @property float                      $management_expense
 * @property float                      $turnover
 * @property float                      $trading_cost
 * @property float                      $wrap_fee
 * @property AssetsConsolidationsTable  $table
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class AssetsConsolidations extends Model implements BelongToMemberInterface
{
    /**
     * @var array<string>
     */
    protected $fillable = [
        'member_id',
        'name',
        'amount',
        'management_expense',
        'turnover',
        'trading_cost',
        'wrap_fee',
        'table',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'name'               => null,
        'amount'             => null,
        'management_expense' => null,
        'turnover'           => null,
        'trading_cost'       => null,
        'wrap_fee'           => null,
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
        'created_at'         => 'datetime',
        'updated_at'         => 'datetime',
        'amount'             => 'float',
        'management_expense' => 'float',
        'turnover'           => 'float',
        'trading_cost'       => 'float',
        'wrap_fee'           => 'float',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'AssetsConsolidations';

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function getHashedTable(): string
    {
        return $this->getHashedKey('table');
    }

    public function table(): BelongsTo
    {
        return $this->belongsTo(AssetsConsolidationsTable::class);
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class BlueprintConcern.
 *
 * @OA\Schema (
 *     title="BlueprintConcern",
 *     description="Blueprint Concern Basic Info",
 *     @OA\Property (
 *          property="id",
 *          type="string",
 *          example="egrlyazq98mno3k0"
 *     ),
 *     @OA\Property (
 *          property="high_fees",
 *          type="boolean",
 *          example=true
 *     ),
 *     @OA\Property (
 *          property="extremely_high_market_exposure",
 *          type="boolean",
 *          example=true
 *     ),
 *     @OA\Property (
 *          property="simple",
 *          type="boolean",
 *          example=true
 *     ),
 *     @OA\Property (
 *          property="keep_the_money_safe",
 *          type="boolean",
 *          example=true
 *     ),
 *     @OA\Property (
 *          property="massive_overlap",
 *          type="boolean",
 *          example=true
 *     ),
 *     @OA\Property (
 *          property="design_implement_monitoring_income_strategy",
 *          type="boolean",
 *          example=true
 *     ),
 * )
 *
 * @property int                        $id
 * @property int                        $member_id
 * @property float                      $high_fees
 * @property float                      $extremely_high_market_exposure
 * @property float                      $simple
 * @property float                      $keep_the_money_safe
 * @property float                      $massive_overlap
 * @property float                      $design_implement_monitoring_income_strategy
 * @property Member                     $member
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class BlueprintConcern extends Model implements BelongToMemberInterface
{
    /**
     * @var array<string>
     */
    protected $fillable = [
        'member_id',
        'high_fees',
        'extremely_high_market_exposure',
        'simple',
        'keep_the_money_safe',
        'massive_overlap',
        'design_implement_monitoring_income_strategy',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'high_fees'                                   => false,
        'extremely_high_market_exposure'              => false,
        'simple'                                      => false,
        'keep_the_money_safe'                         => false,
        'massive_overlap'                             => false,
        'design_implement_monitoring_income_strategy' => false,
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
        'created_at'                                    => 'datetime',
        'updated_at'                                    => 'datetime',
        'high_fees'                                     => 'bool',
        'extremely_high_market_exposure'                => 'bool',
        'simple'                                        => 'bool',
        'keep_the_money_safe'                           => 'bool',
        'massive_overlap'                               => 'bool',
        'design_implement_monitoring_income_strategy'   => 'bool',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Blueprint';

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}

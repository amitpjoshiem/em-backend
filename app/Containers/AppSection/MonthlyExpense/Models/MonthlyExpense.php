<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class MonthlyExpense.
 *
 * @OA\Schema (
 *     title="MonthlyExpense",
 *     description="MonthlyExpense Basic Info",
 *     @OA\Property (
 *          property="housing",
 *          type="object",
 *          @OA\Property(
 *              property="mortgage_rent_fees",
 *              type="object",
 *              @OA\Property(
 *                  property="essential",
 *                  type="integer",
 *                  example="1"
 *              ),
 *              @OA\Property(
 *                  property="discretionary",
 *                  type="integer",
 *                  example="1"
 *              ),
 *          ),
 *          @OA\Property(
 *              property="property_taxes_and_insurance",
 *              type="object",
 *              @OA\Property(
 *                  property="essential",
 *                  type="integer",
 *                  example="1"
 *              ),
 *              @OA\Property(
 *                  property="discretionary",
 *                  type="integer",
 *                  example="1"
 *              ),
 *          ),
 *          @OA\Property(
 *              property="utilities",
 *              type="object",
 *              @OA\Property(
 *                  property="essential",
 *                  type="integer",
 *                  example="1"
 *              ),
 *              @OA\Property(
 *                  property="discretionary",
 *                  type="integer",
 *                  example="1"
 *              ),
 *          ),
 *          @OA\Property(
 *              property="household_improvement",
 *              type="object",
 *              @OA\Property(
 *                  property="essential",
 *                  type="integer",
 *                  example="1"
 *              ),
 *              @OA\Property(
 *                  property="discretionary",
 *                  type="integer",
 *                  example="1"
 *              ),
 *          ),
 *          @OA\Property(
 *              property="household_maintenance",
 *              type="object",
 *              @OA\Property(
 *                  property="essential",
 *                  type="integer",
 *                  example="1"
 *              ),
 *              @OA\Property(
 *                  property="discretionary",
 *                  type="integer",
 *                  example="1"
 *              ),
 *          )
 *     ),
 *     @OA\Property (
 *          property="food_transportation",
 *          type="object",
 *          @OA\Property(
 *              property="at_home",
 *              type="object",
 *              @OA\Property(
 *                  property="essential",
 *                  type="integer",
 *                  example="1"
 *              ),
 *              @OA\Property(
 *                  property="discretionary",
 *                  type="integer",
 *                  example="1"
 *              ),
 *          ),
 *          @OA\Property(
 *              property="dining_out",
 *              type="object",
 *              @OA\Property(
 *                  property="essential",
 *                  type="integer",
 *                  example="1"
 *              ),
 *              @OA\Property(
 *                  property="discretionary",
 *                  type="integer",
 *                  example="1"
 *              ),
 *          ),
 *          @OA\Property(
 *              property="vehicle_purchases_payments",
 *              type="object",
 *              @OA\Property(
 *                  property="essential",
 *                  type="integer",
 *                  example="1"
 *              ),
 *              @OA\Property(
 *                  property="discretionary",
 *                  type="integer",
 *                  example="1"
 *              ),
 *          ),
 *          @OA\Property(
 *              property="auto_insurance_and_taxes",
 *              type="object",
 *              @OA\Property(
 *                  property="essential",
 *                  type="integer",
 *                  example="1"
 *              ),
 *              @OA\Property(
 *                  property="discretionary",
 *                  type="integer",
 *                  example="1"
 *              ),
 *          ),
 *          @OA\Property(
 *              property="fuel_and_maintenance",
 *              type="object",
 *              @OA\Property(
 *                  property="essential",
 *                  type="integer",
 *                  example="1"
 *              ),
 *              @OA\Property(
 *                  property="discretionary",
 *                  type="integer",
 *                  example="1"
 *              ),
 *          ),
 *          @OA\Property(
 *              property="public_transportation",
 *              type="object",
 *              @OA\Property(
 *                  property="essential",
 *                  type="integer",
 *                  example="1"
 *              ),
 *              @OA\Property(
 *                  property="discretionary",
 *                  type="integer",
 *                  example="1"
 *              ),
 *          )
 *     ),
 *     @OA\Property (
 *          property="healthcare",
 *          type="object",
 *          @OA\Property(
 *              property="health_insurance",
 *              type="object",
 *              @OA\Property(
 *                  property="essential",
 *                  type="integer",
 *                  example="1"
 *              ),
 *              @OA\Property(
 *                  property="discretionary",
 *                  type="integer",
 *                  example="1"
 *              ),
 *          ),
 *          @OA\Property(
 *              property="medicare_medigap",
 *              type="object",
 *              @OA\Property(
 *                  property="essential",
 *                  type="integer",
 *                  example="1"
 *              ),
 *              @OA\Property(
 *                  property="discretionary",
 *                  type="integer",
 *                  example="1"
 *              ),
 *          ),
 *          @OA\Property(
 *              property="copays_uncovered_medical_services",
 *              type="object",
 *              @OA\Property(
 *                  property="essential",
 *                  type="integer",
 *                  example="1"
 *              ),
 *              @OA\Property(
 *                  property="discretionary",
 *                  type="integer",
 *                  example="1"
 *              ),
 *          ),
 *          @OA\Property(
 *              property="drugs_and_medical_supplies",
 *              type="object",
 *              @OA\Property(
 *                  property="essential",
 *                  type="integer",
 *                  example="1"
 *              ),
 *              @OA\Property(
 *                  property="discretionary",
 *                  type="integer",
 *                  example="1"
 *              ),
 *          ),
 *     ),
 *     @OA\Property (
 *          property="personal_insurance",
 *          type="object",
 *          @OA\Property(
 *              property="life_other",
 *              type="object",
 *              @OA\Property(
 *                  property="essential",
 *                  type="integer",
 *                  example="1"
 *              ),
 *              @OA\Property(
 *                  property="discretionary",
 *                  type="integer",
 *                  example="1"
 *              ),
 *          ),
 *          @OA\Property(
 *              property="long_term_care",
 *              type="object",
 *              @OA\Property(
 *                  property="essential",
 *                  type="integer",
 *                  example="1"
 *              ),
 *              @OA\Property(
 *                  property="discretionary",
 *                  type="integer",
 *                  example="1"
 *              ),
 *          ),
 *          @OA\Property(
 *              property="clothing",
 *              type="object",
 *              @OA\Property(
 *                  property="essential",
 *                  type="integer",
 *                  example="1"
 *              ),
 *              @OA\Property(
 *                  property="discretionary",
 *                  type="integer",
 *                  example="1"
 *              ),
 *          ),
 *          @OA\Property(
 *              property="product_and_services",
 *              type="object",
 *              @OA\Property(
 *                  property="essential",
 *                  type="integer",
 *                  example="1"
 *              ),
 *              @OA\Property(
 *                  property="discretionary",
 *                  type="integer",
 *                  example="1"
 *              ),
 *          ),
 *     ),
 *     @OA\Property(
 *          property="entertainment",
 *          type="object",
 *          @OA\Property(
 *              property="essential",
 *              type="integer",
 *              example="1"
 *          ),
 *          @OA\Property(
 *              property="discretionary",
 *              type="integer",
 *              example="1"
 *          ),
 *     ),
 *     @OA\Property(
 *          property="travel",
 *          type="object",
 *          @OA\Property(
 *              property="essential",
 *              type="integer",
 *              example="1"
 *          ),
 *          @OA\Property(
 *              property="discretionary",
 *              type="integer",
 *              example="1"
 *          ),
 *     ),
 *     @OA\Property(
 *          property="hobbies",
 *          type="object",
 *          @OA\Property(
 *              property="essential",
 *              type="integer",
 *              example="1"
 *          ),
 *          @OA\Property(
 *              property="discretionary",
 *              type="integer",
 *              example="1"
 *          ),
 *     ),
 *     @OA\Property(
 *          property="family_care_education",
 *          type="object",
 *          @OA\Property(
 *              property="essential",
 *              type="integer",
 *              example="1"
 *          ),
 *          @OA\Property(
 *              property="discretionary",
 *              type="integer",
 *              example="1"
 *          ),
 *     ),
 *     @OA\Property(
 *          property="income_taxes",
 *          type="object",
 *          @OA\Property(
 *              property="essential",
 *              type="integer",
 *              example="1"
 *          ),
 *          @OA\Property(
 *              property="discretionary",
 *              type="integer",
 *              example="1"
 *          ),
 *     ),
 *     @OA\Property(
 *          property="charitable_contributions",
 *          type="object",
 *          @OA\Property(
 *              property="essential",
 *              type="integer",
 *              example="1"
 *          ),
 *          @OA\Property(
 *              property="discretionary",
 *              type="integer",
 *              example="1"
 *          ),
 *     ),
 *     @OA\Property(
 *          property="other",
 *          type="object",
 *          @OA\Property(
 *              property="essential",
 *              type="integer",
 *              example="1"
 *          ),
 *          @OA\Property(
 *              property="discretionary",
 *              type="integer",
 *              example="1"
 *          ),
 *     ),
 * )
 *
 * @property Member $member
 * @property int    $user_id
 */
class MonthlyExpense extends Model implements BelongToMemberInterface
{
    /**
     * @var string
     */
    public const OTHER_GROUP = 'group';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'member_id',
        'group',
        'item',
        'essential',
        'discretionary',
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
        'essential'     => 'float',
        'discretionary' => 'float',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'MonthlyExpense';

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}

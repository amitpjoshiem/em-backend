<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class BlueprintMonthlyIncome.
 *
 * @OA\Schema (
 *     title="BlueprintMonthlyIncome",
 *     description="Blueprint Monthly Income Basic Info",
 *     @OA\Property (
 *          property="id",
 *          type="string",
 *          example="egrlyazq98mno3k0"
 *     ),
 *     @OA\Property (
 *          property="current_member",
 *          type="float",
 *          example=9999.999
 *     ),
 *     @OA\Property (
 *          property="current_spouse",
 *          type="float",
 *          example=9999.999
 *     ),
 *     @OA\Property (
 *          property="current_pensions",
 *          type="float",
 *          example=9999.999
 *     ),
 *     @OA\Property (
 *          property="current_rental_income",
 *          type="float",
 *          example=9999.999
 *     ),
 *     @OA\Property (
 *          property="current_investment",
 *          type="float",
 *          example=9999.999
 *     ),
 *     @OA\Property (
 *          property="future_member",
 *          type="float",
 *          example=9999.999
 *     ),
 *     @OA\Property (
 *          property="future_spouse",
 *          type="float",
 *          example=9999.999
 *     ),
 *     @OA\Property (
 *          property="future_pensions",
 *          type="float",
 *          example=9999.999
 *     ),
 *     @OA\Property (
 *          property="future_rental_income",
 *          type="float",
 *          example=9999.999
 *     ),
 *     @OA\Property (
 *          property="future_investment",
 *          type="float",
 *          example=9999.999
 *     ),
 *     @OA\Property (
 *          property="tax",
 *          type="float",
 *          example=9999.999
 *     ),
 *     @OA\Property (
 *          property="ira_first",
 *          type="float",
 *          example=9999.999
 *     ),
 *     @OA\Property (
 *          property="ira_second",
 *          type="float",
 *          example=9999.999
 *     ),
 * )
 *
 * @property int                        $id
 * @property int                        $member_id
 * @property float                      $current_member
 * @property float                      $current_spouse
 * @property float                      $current_pensions
 * @property float                      $current_rental_income
 * @property float                      $current_investment
 * @property float                      $future_member
 * @property float                      $future_spouse
 * @property float                      $future_pensions
 * @property float                      $future_rental_income
 * @property float                      $future_investment
 * @property float                      $tax
 * @property float                      $ira_first
 * @property float                      $ira_second
 * @property Member                     $member
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class BlueprintMonthlyIncome extends Model implements BelongToMemberInterface
{
    /**
     * @var array<string>
     */
    protected $fillable = [
        'member_id',
        'current_member',
        'current_spouse',
        'current_pensions',
        'current_rental_income',
        'current_investment',
        'future_member',
        'future_spouse',
        'future_pensions',
        'future_rental_income',
        'future_investment',
        'tax',
        'ira_first',
        'ira_second',
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
        'current_member'        => 'float',
        'current_spouse'        => 'float',
        'current_pensions'      => 'float',
        'current_rental_income' => 'float',
        'current_investment'    => 'float',
        'future_member'         => 'float',
        'future_spouse'         => 'float',
        'future_pensions'       => 'float',
        'future_rental_income'  => 'float',
        'future_investment'     => 'float',
        'tax'                   => 'float',
        'ira_first'             => 'float',
        'ira_second'            => 'float',
        'created_at'            => 'datetime',
        'updated_at'            => 'datetime',
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

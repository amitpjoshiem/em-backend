<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Models;

use App\Containers\AppSection\AssetsIncome\Data\Enums\TypesEnum;
use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="AssetsIncome",
 *     schema="AssetsIncome",
 *     description="AssetsIncome Values",
 *     @OA\Property(
 *          property="group",
 *          type="array",
 *          example="current_income",
 *          @OA\Items(
 *              @OA\Property(
 *                  property="row",
 *                  type="array",
 *                  @OA\Items(
 *                      @OA\Property(property="value", type="mixed", example="12")
 *                  ),
 *              ),
 *          )
 *     ),
 * )
 *
 * @property int                        $id
 * @property string                     $group
 * @property string                     $row
 * @property string                     $element
 * @property string                     $type
 * @property string | null              $value
 * @property string | null              $parent
 * @property Member                     $member
 * @property bool                       $joined
 * @property bool                       $can_join
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class AssetsIncomeValue extends Model implements BelongToMemberInterface
{
    /**
     * @var array<string>
     */
    protected $fillable = [
        'group',
        'row',
        'element',
        'type',
        'parent',
        'value',
        'joined',
        'member_id',
        'can_join',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'joined'   => false,
        'can_join' => false,
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
        'type'      => TypesEnum::class,
        'joined'    => 'boolean',
        'can_join'  => 'boolean',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'AssetsIncomeValue';

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}

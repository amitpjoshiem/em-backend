<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class MemberOther.
 *
 * @OA\Schema (
 *     title="Member Other",
 *     description="Member Other Info",
 *     required={"id"},
 *     @OA\Property (
 *          property="id",
 *          type="string",
 *          example="egrlyazq98mno3k0"
 *     ),
 *     @OA\Property (
 *          property="risk",
 *          description="One of the type (conservative|moderately_conservative|moderate|moderately_aggressive|aggressive)",
 *          type="string",
 *          example="Name"
 *     ),
 *     @OA\Property (
 *          property="questions",
 *          type="string",
 *          example="Question text, is it?"
 *     ),
 *     @OA\Property (
 *          property="retirement",
 *          type="string",
 *          example="Example Retirement Text"
 *     ),
 *     @OA\Property (
 *          property="retirement_money",
 *          type="string",
 *          example="Example Retirement Money Text"
 *     ),
 *     @OA\Property (
 *          property="work_with_advisor",
 *          type="boolean",
 *          example=true
 *     )
 * )
 *
 * @property int    $id
 * @property int    $member_id
 * @property string $risk
 * @property string $questions
 * @property string $retirement
 * @property string $retirement_money
 * @property bool   $work_with_advisor
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class MemberOther extends Model implements BelongToMemberInterface
{
    /**
     * @var string
     */
    public const CONSERVATIVE = 'conservative';

    /**
     * @var string
     */
    public const MODERATELY_CONSERVATIVE = 'moderately_conservative';

    /**
     * @var string
     */
    public const MODERATE = 'moderate';

    /**
     * @var string
     */
    public const MODERATELY_AGGRESSIVE = 'moderately_aggressive';

    /**
     * @var string
     */
    public const AGGRESSIVE = 'aggressive';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'risk',
        'questions',
        'retirement',
        'retirement_money',
        'work_with_advisor',
        'member_id',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
        'work_with_advisor' => 'bool',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'MemberOther';

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * Class MemberEmploymentHistory.
 *
 * @OA\Schema (
 *     title="Member Employment History",
 *     description="Member Employment History Info",
 *     required={"id"},
 *     @OA\Property (
 *          property="id",
 *          type="string",
 *          example="egrlyazq98mno3k0"
 *     ),
 *     @OA\Property (
 *          property="company_name",
 *          type="string",
 *          example="Name Of Company"
 *     ),
 *     @OA\Property (
 *          property="occupation",
 *          type="string",
 *          example="Test Occupation Name"
 *     ),
 *     @OA\Property (
 *          property="years",
 *          type="int",
 *          example=5
 *     ),
 * )
 *
 * @property int    $id
 * @property string $company_name
 * @property string $occupation
 * @property string $years
 * @property string $memberable_type
 * @property int    $memberable_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class MemberEmploymentHistory extends Model implements BelongToMemberInterface
{
    /**
     * @var string
     */
    public const COMPANY_NAME = 'company_name';

    /**
     * @var string
     */
    public const OCCUPATION = 'occupation';

    /**
     * @var string
     */
    public const YEARS = 'years';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'company_name',
        'occupation',
        'years',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'MemberEmploymentHistory';

    public function member(): MorphTo
    {
        return $this->morphTo();
    }
}

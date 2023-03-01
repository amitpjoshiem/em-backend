<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * * @OA\Schema (
 *     title="AssetsConsolidationsTable",
 *     schema="AssetsConsolidationsTable",
 *     description="AssetsConsolidationsTable Basic Info",
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
 *          property="wrap_fee",
 *          type="float",
 *          example="99.99"
 *     ),
 * )
 *
 * @property int          $id
 * @property string       $name
 * @property Collection   $rows
 * @property Member       $member
 * @property float | null $wrap_fee
 */
class AssetsConsolidationsTable extends Model implements BelongToMemberInterface
{
    /**
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'wrap_fee',
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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'wrap_fee'   => 'float',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'AssetsConsolidationsTable';

    public function rows(): HasMany
    {
        return $this->hasMany(AssetsConsolidations::class, 'table_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}

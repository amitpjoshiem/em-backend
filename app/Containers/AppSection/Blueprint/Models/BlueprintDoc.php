<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Models\Media;
use App\Containers\AppSection\Media\Traits\InteractsWithMedia;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class BlueprintDoc.
 *
 * @OA\Schema (
 *     title="BlueprintDoc",
 *     description="Blueprint Doc Basic Info",
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
 * @property Member                     $member
 * @property User                       $user
 * @property Media | null               $doc
 * @property string                     $type
 * @property string                     $filename
 * @property string                     $status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class BlueprintDoc extends Model implements HasInteractsWithMedia, BelongToMemberInterface
{
    use InteractsWithMedia;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'member_id',
        'media_id',
        'type',
        'filename',
        'status',
        'created_at',
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
        'created_at'                                    => 'datetime',
        'updated_at'                                    => 'datetime',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'BlueprintDocs';

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCollection(): string
    {
        return MediaCollectionEnum::BLUEPRINT_DOC;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection($this->getCollection())->singleFile();
    }

    public function getAuthorId(): ?int
    {
        return $this->user->getKey();
    }

    public function doc(): HasOne
    {
        return $this->hasOne(Media::class, 'id', 'media_id');
    }
}

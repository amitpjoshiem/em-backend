<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Models\Media;
use App\Containers\AppSection\Media\Traits\InteractsWithMedia;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * @property int                        $id
 * @property Member                     $member
 * @property User                       $user
 * @property Media                      $doc
 * @property string                     $type
 * @property string                     $filename
 * @property string|null                $url
 * @property string                     $status
 * @property Collection                 $contracts
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class ClientReportsDoc extends Model implements HasInteractsWithMedia, BelongToMemberInterface
{
    use InteractsWithMedia;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'member_id',
        'type',
        'media_id',
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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'AssetsConsolidationsExport';

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function doc(): HasOne
    {
        return $this->hasOne(Media::class, 'id', 'media_id');
    }

    public function getAuthorId(): ?int
    {
        return $this->user->getKey();
    }

    public function getCollection(): string
    {
        return MediaCollectionEnum::CLIENT_REPORT_DOC;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection($this->getCollection())->singleFile();
    }

    public function contracts(): BelongsToMany
    {
        return $this->belongsToMany(ClientReport::class, 'client_reports_doc_client_report');
    }
}

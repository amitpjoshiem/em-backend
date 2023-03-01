<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\FixedIndexAnnuities\Exceptions\DocumentMissingException;
use App\Containers\AppSection\FixedIndexAnnuities\SubActions\AttachDocumentSubAction;
use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Models\Media;
use App\Containers\AppSection\Media\Tasks\DeleteMediaTask;
use App\Containers\AppSection\Media\Traits\InteractsWithMedia;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int                             $id
 * @property string                          $name
 * @property string                          $insurance_provider
 * @property \Illuminate\Support\Carbon|null $advisor_signed
 * @property \Illuminate\Support\Carbon|null $client_signed
 * @property string                          $tax_qualification
 * @property string                          $agent_rep_code
 * @property string                          $license_number
 * @property \Illuminate\Support\Carbon      $created_at
 * @property \Illuminate\Support\Carbon      $updated_at
 * @property Member                          $member
 * @property Collection                      $investmentPackages
 */
class FixedIndexAnnuities extends Model implements HasInteractsWithMedia, BelongToMemberInterface, DocumentInterface
{
    use InteractsWithMedia;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'insurance_provider',
        'advisor_signed',
        'client_signed',
        'tax_qualification',
        'agent_rep_code',
        'license_number',
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
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
        'advisor_signed' => 'datetime',
        'client_signed'  => 'datetime',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'FixedIndexAnnuities';

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function getAuthorId(): ?int
    {
        return $this->member->user_id;
    }

    public function getCollection(): string
    {
        return MediaCollectionEnum::FIXED_INDEX_ANNUITIES;
    }

    public function investmentPackages(): HasMany
    {
        return $this->hasMany(InvestmentPackage::class);
    }

    public function getDocument(): Media
    {
        /** @var Media | null $media */
        $media = $this->getMedia($this->getCollection())->first();

        if ($media === null) {
            throw new DocumentMissingException();
        }

        return $media;
    }

    /** @psalm-suppress MoreSpecificReturnType */
    public function getCertificate(): ?Media
    {
        /** @psalm-suppress LessSpecificReturnStatement */
        return $this->getMedia(MediaCollectionEnum::DOCUSIGN_CERTIFICATE)->first();
    }

    public function advisorSign(Carbon $date): bool
    {
        return $this->update(['advisor_signed' => $date]);
    }

    public function clientSign(Carbon $date): bool
    {
        return $this->update(['client_signed' => $date]);
    }

    public function updateDocument(UploadedFile $file): void
    {
        app(DeleteMediaTask::class)->run($this->getDocument()->getKey());
        app(AttachDocumentSubAction::class)->run($file, $this->getCollection(), $this);
    }

    public function updateCertificate(UploadedFile $file): void
    {
        $certificate = $this->getCertificate();

        if ($certificate !== null) {
            app(DeleteMediaTask::class)->run($certificate->getKey());
        }

        app(AttachDocumentSubAction::class)->run($file, MediaCollectionEnum::DOCUSIGN_CERTIFICATE, $this);
    }

    public function isCompleted(): bool
    {
        return $this->advisor_signed !== null && $this->client_signed !== null;
    }
}

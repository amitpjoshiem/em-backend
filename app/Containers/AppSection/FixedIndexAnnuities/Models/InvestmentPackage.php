<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Models;

use App\Containers\AppSection\FixedIndexAnnuities\Exceptions\DocumentMissingException;
use App\Containers\AppSection\FixedIndexAnnuities\SubActions\AttachDocumentSubAction;
use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Models\Media;
use App\Containers\AppSection\Media\Tasks\DeleteMediaTask;
use App\Containers\AppSection\Media\Traits\InteractsWithMedia;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

/**
 * @property int                             $id
 * @property string                          $name
 * @property \Illuminate\Support\Carbon|null $advisor_signed
 * @property \Illuminate\Support\Carbon|null $client_signed
 * @property \Illuminate\Support\Carbon      $created_at
 * @property \Illuminate\Support\Carbon      $updated_at
 * @property FixedIndexAnnuities             $fixedIndexAnnuities
 */
class InvestmentPackage extends Model implements HasInteractsWithMedia, DocumentInterface
{
    use InteractsWithMedia;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'advisor_signed',
        'client_signed',
        'fixed_index_annuities_id',
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
    protected string $resourceKey = 'InvestmentPackage';

    public function fixedIndexAnnuities(): BelongsTo
    {
        return $this->belongsTo(FixedIndexAnnuities::class);
    }

    public function getAuthorId(): ?int
    {
        return $this->fixedIndexAnnuities->getAuthorId();
    }

    public function getCollection(): string
    {
        return MediaCollectionEnum::INVESTMENT_PACKAGE;
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

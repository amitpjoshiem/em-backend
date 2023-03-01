<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Models;

use App\Containers\AppSection\Media\Models\Media;
use App\Containers\AppSection\Salesforce\Exceptions\ExportExceptions\OwnerNotExistException;
use App\Containers\AppSection\Salesforce\Exceptions\SalesforceObjectIdException;
use App\Containers\AppSection\Salesforce\Services\Objects\Attachment;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Models\Model;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int                       $id
 * @property string                    $salesforce_id
 * @property int                       $object_id
 * @property string                    $object_class
 * @property string|null               $custom_name
 * @property SalesforceObjectInterface $object
 * @property Media                     $media
 * @property User                      $user
 */
class SalesforceAttachment extends Model implements SalesforceObjectInterface
{
    /**
     * @var array<string>
     */
    protected $fillable = [
        'object_id',
        'object_class',
        'media_id',
        'salesforce_id',
        'user_id',
        'custom_name',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'SalesforceAttachment';

    public function api(): Attachment
    {
        return new Attachment($this);
    }

    public static function prepareSalesforceData(int $id, bool $isUpdate): array
    {
        /** @var self $attachment */
        $attachment = self::with(['media', 'user.salesforce'])->find($id);

        $file = file_get_contents($attachment->media->getTemporaryUrl(now()->addSeconds(10)));

        $file = base64_encode($file);

        $object = $attachment->object;

        if (!$object instanceof SalesforceObjectInterface) {
            throw new SalesforceObjectIdException();
        }

        /** @psalm-suppress UndefinedMagicPropertyFetch */
        $salesforceId = $object->salesforce_id;

        if ($salesforceId === null) {
            throw new SalesforceObjectIdException();
        }

        try {
            $ownerID = $attachment->user->salesforce->salesforce_id;
        } catch (Exception) {
            throw new OwnerNotExistException();
        }

        return [
            'ParentId'    => $salesforceId,
            'Name'        => $attachment->custom_name ?? $attachment->media->file_name,
            'IsPrivate'   => false,
            'Body'        => $file,
            'ContentType' => $attachment->media->mime_type,
            'OwnerId'     => $ownerID,
        ];
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getObjectAttribute(): \Illuminate\Database\Eloquent\Model|Collection|Model|array|null
    {
        /**
         * @var Model $model
         * @psalm-suppress InvalidStringClass
         */
        $model = new $this->object_class();

        return $model->find($this->object_id);
    }

    public function getSalesforceId(): ?string
    {
        return $this->salesforce_id;
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Models;

use App\Ship\Core\Traits\HashIdTrait;
use App\Ship\Core\Traits\HasResourceKeyTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseModel;

/**
 * Class Media.
 *
 * @OA\Schema (
 *     title="Media",
 *     description="Media data model",
 *     @OA\Property (
 *          property="object",
 *          type="string",
 *          example="Media"
 *     ),
 *     @OA\Property (
 *          property="id",
 *          type="string",
 *          example="qajd5mljorznp6o9"
 *     ),
 *     @OA\Property (
 *          property="url",
 *          type="string",
 *          example="https://viator-public.s3.eu-central-1.amazonaws.com/local/avatar/1/image.jpg"
 *     ),
 *     @OA\Property (
 *          property="name",
 *          type="string",
 *          example="User"
 *     ),
 *     @OA\Property (
 *          property="file_name",
 *          type="string",
 *          example="image.jpg"
 *     ),
 *     @OA\Property (
 *          property="mime_type",
 *          type="string",
 *          example="image/jpeg"
 *     ),
 *     @OA\Property (
 *          property="human_readable_size",
 *          type="string",
 *          example="222.19 KB"
 *     ),
 *     @OA\Property (
 *          property="size",
 *          type="integer",
 *          format="int64",
 *          example="227519"
 *     ),
 *     @OA\Property (
 *          property="order",
 *          type="integer",
 *          format="int32",
 *          example="2"
 *     ),
 *     @OA\Property (
 *          property="custom_properties",
 *          type="array",
 *          @OA\Items(type="string")
 *     ),
 *     @OA\Property (
 *          property="extension",
 *          type="string",
 *          example="jpg"
 *     ),
 *     @OA\Property (
 *          property="links",
 *          type="object",
 *          @OA\Property(
 *              property="delete",
 *              type="object",
 *              @OA\Property(
 *                  property="href",
 *                  type="string",
 *                  example="/api/v1/media/qajd5mljorznp6o9"
 *              ),
 *              @OA\Property(
 *                  property="method",
 *                  type="string",
 *                  example="DELETE"
 *              )
 *          )
 *     ),
 * )
 *
 * @property      int                             $id
 * @property      string                          $model_type
 * @property      int                             $model_id
 * @property      string|null                     $uuid
 * @property      string                          $collection_name
 * @property      string                          $name
 * @property      string                          $file_name
 * @property      string|null                     $mime_type
 * @property      string                          $disk
 * @property      string|null                     $conversions_disk
 * @property      int                             $size
 * @property      array                           $manipulations
 * @property      array                           $custom_properties
 * @property      array                           $generated_conversions
 * @property      array                           $responsive_images
 * @property      int|null                        $order_column
 * @property      \Illuminate\Support\Carbon|null $created_at
 * @property      \Illuminate\Support\Carbon|null $updated_at
 * @property-read string                          $extension
 * @property-read string                          $human_readable_size
 * @property-read string                          $type
 * @property-read Model|Eloquent                  $model
 * @property-read TemporaryUpload                 $temporaryUpload
 *
 * @method static MediaCollection|static[] all($columns = ['*'])
 * @method static MediaCollection|static[] get($columns = ['*'])
 * @method static Builder|Media newModelQuery()
 * @method static Builder|Media newQuery()
 * @method static Builder|BaseModel ordered()
 * @method static Builder|Media query()
 * @method static Builder|Media whereCollectionName($value)
 * @method static Builder|Media whereConversionsDisk($value)
 * @method static Builder|Media whereCreatedAt($value)
 * @method static Builder|Media whereCustomProperties($value)
 * @method static Builder|Media whereDisk($value)
 * @method static Builder|Media whereFileName($value)
 * @method static Builder|Media whereGeneratedConversions($value)
 * @method static Builder|Media whereId($value)
 * @method static Builder|Media whereManipulations($value)
 * @method static Builder|Media whereMimeType($value)
 * @method static Builder|Media whereModelId($value)
 * @method static Builder|Media whereModelType($value)
 * @method static Builder|Media whereName($value)
 * @method static Builder|Media whereOrderColumn($value)
 * @method static Builder|Media whereResponsiveImages($value)
 * @method static Builder|Media whereSize($value)
 * @method static Builder|Media whereUpdatedAt($value)
 * @method static Builder|Media whereUuid($value)
 * @mixin Eloquent
 */
class Media extends BaseModel
{
    use HashIdTrait;
    use HasResourceKeyTrait;

    protected static bool $useLogger = false;

    /**
     * A resource key to be used by the the JSON API Serializer responses.
     */
    protected string $resourceKey = 'Media';

    // Relation

    public function temporaryUpload(): BelongsTo
    {
        return $this->belongsTo(TemporaryUpload::class);
    }
}

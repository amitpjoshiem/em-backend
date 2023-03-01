<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\UI\API\Transformers;

use App\Containers\AppSection\Media\Models\Media;
use App\Ship\Parents\Transformers\Transformer;
use Exception;
use Illuminate\Support\Str;
use League\Fractal\Resource\Item;
use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\MediaLibrary\Conversions\ConversionCollection;

class MediaTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $availableIncludes = [
        'details',
    ];

    public function __construct(public bool $withMediaExpiration = false, public string $unit = 'hour', public int $value = 1)
    {
    }

    public function transform(Media $entity): array
    {
        return [
            'object'      => $entity->getResourceKey(),
            'id'          => $entity->getHashedKey(),
            'url'         => $this->getMediaUrlByFlag($entity),
            'name'        => $entity->name,
            'file_name'   => $entity->file_name,
            'extension'   => $entity->extension,
            'conversions' => $this->getConversions($entity),
            'links'       => [
                'delete' => [
                    'href'   => Str::remove('/api/v1', route('api_media_delete_media', [$entity->getHashedKey()], false)),
                    'method' => 'DELETE',
                ],
            ],
        ];
    }

    public function includeDetails(Media $entity): Item
    {
        $response = [
            'status'              => $this->mediaStatus($entity),
            'mime_type'           => $entity->mime_type,
            'human_readable_size' => $entity->human_readable_size,
            'size'                => $entity->size,
            'order'               => $entity->order_column,
            'progress'            => $entity->getCustomProperty('progress'),
            'custom_properties'   => $entity->custom_properties,
            'duration'            => $this->isVideo($entity) || $this->isAudio($entity) ? (float)$entity->getCustomProperty('duration') : 0.0,
        ];

        $additionalResp = $this->isImage($entity) ? [
            'width'  => $entity->getCustomProperty('width'),
            'height' => $entity->getCustomProperty('height'),
            'ratio'  => (float)$entity->getCustomProperty('ratio'),
        ] : [];

        $response = array_merge($additionalResp, $response);

        return $this->item($response, fn (array $response): array => $response, 'Details');
    }

    /**
     * Determine if the media type is video.
     */
    private function isVideo(Media $entity): bool
    {
        return $this->getType($entity) === 'video';
    }

    /**
     * Determine if the media type is image.
     */
    private function isImage(Media $entity): bool
    {
        return $this->getType($entity) === 'image';
    }

    /**
     * Determine if the media type is audio.
     */
    private function isAudio(Media $entity): bool
    {
        return $this->getType($entity) === 'audio';
    }

    /**
     * Get the media type.
     */
    private function getType(Media $entity): string
    {
        return $entity->getCustomProperty('type') ?: $entity->type;
    }

    private function mediaStatus(Media $entity): string
    {
        return $entity->getCustomProperty('status');
    }

    /**
     * Get the generated conversions links.
     */
    private function getConversions(Media $entity): array
    {
        $results = [];

        if (!$this->isImage($entity) && !$this->isVideo($entity)) {
            return $results;
        }

        foreach (array_keys($entity->getGeneratedConversions()->toArray()) as $conversionName) {
            $conversion = ConversionCollection::createForMedia($entity)
                ->first(fn (Conversion $conversion): bool => $conversion->getName() === $conversionName);

            if ($conversion) {
                $results[$conversionName] = $this->getMediaUrlByFlag($entity, $conversionName);
            }
        }

        return $results;
    }

    private function getMediaUrlByFlag(Media $entity, string $conversionName = ''): string
    {
        try {
            return $this->withMediaExpiration ? $entity->getTemporaryUrl(now()->add($this->unit, $this->value)) : $entity->getFullUrl($conversionName);
        } catch (Exception) {
            //  If the Adapter doesn't have the getTemporaryUrl method
            return $entity->getFullUrl($conversionName);
        }
    }
}

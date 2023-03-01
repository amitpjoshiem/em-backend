<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Actions;

use App\Containers\AppSection\Media\Data\Transporters\GetCollectionMediaRulesOutputTransporter;
use App\Containers\AppSection\Media\Data\Transporters\GetCollectionMediaRulesTransporter;
use App\Ship\Parents\Actions\Action;
use GuzzleHttp\Psr7\MimeType;

class GetCollectionMediaRulesAction extends Action
{
    public function run(GetCollectionMediaRulesTransporter $data): GetCollectionMediaRulesOutputTransporter
    {
        $size = config(sprintf('media-container.collection_size.%s', $data->collection));

        return new GetCollectionMediaRulesOutputTransporter([
            'size'          => $size !== null ? $size / 1024 : static::getDefaultFileSize(),
            'allowed_types' => $this->getAllowedMimeTypes($data->collection),
        ]);
    }

    public static function getDefaultFileSize(): int
    {
        $iniSize       = ini_get('upload_max_filesize');
        $sizeCharacter = preg_replace('#\d+#u', '', $iniSize);
        $size          = (int)preg_replace('#[a-zA-Z]+#u', '', $iniSize);

        return (int) match ($sizeCharacter) {
            'G'     => $size * 1024,
            'M'     => $size,
            'K'     => $size / 1024,
            default => $size / (1024 * 1024),
        };
    }

    private function getAllowedMimeTypes(string $collection): ?array
    {
        /** @var array|null $types */
        $types = config(sprintf('media-container.collection_types.%s', $collection));

        if ($types === null) {
            return null;
        }

        $result = [];

        foreach ($types as $type) {
            $result[] = [
                'extension' => $type,
                'mimy_type' => MimeType::fromExtension($type),
            ];
        }

        return $result;
    }
}

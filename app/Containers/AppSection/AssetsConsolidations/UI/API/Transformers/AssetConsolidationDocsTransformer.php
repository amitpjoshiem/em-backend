<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\UI\API\Transformers;

use App\Containers\AppSection\Media\Models\Media;
use App\Ship\Parents\Transformers\Transformer;
use Carbon\Carbon;

class AssetConsolidationDocsTransformer extends Transformer
{
    public function transform(Media $doc): array
    {
        $linkExpire = Carbon::now()->addMinutes(config('appSection-member.stress_test_link_expire_minutes'));

        return [
            'id'            => $doc->getHashedKey(),
            'name'          => $doc->file_name,
            'url'           => $this->getUrl($doc, $linkExpire),
            'extension'     => $doc->extension,
            'link_expire'   => $linkExpire->toDateTimeString(),
            'created_at'    => $doc->created_at?->toDateTimeString(),
        ];
    }
}

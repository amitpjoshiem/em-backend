<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\UI\API\Transformers;

use App\Containers\AppSection\Blueprint\Models\BlueprintDoc;
use App\Ship\Parents\Transformers\Transformer;

class BlueprintDocReportTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [

    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(BlueprintDoc $report): array
    {
        return [
            'id'            => $report->getHashedKey(),
            'filename'      => $report->filename,
            'url'           => $report->doc?->getTemporaryUrl(now()->addHour()),
            'media_id'      => $report->doc?->getHashedKey(),
            'extension'     => $report->doc?->getExtensionAttribute(),
            'type'          => $report->type,
            'status'        => $report->status,
            'created_at'    => $report->created_at,
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\UI\API\Transformers;

use App\Containers\AppSection\ClientReport\Models\ClientReportsDoc;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Collection as FractalCollection;

class ClientReportDocTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'contracts',
    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(ClientReportsDoc $report): array
    {
        return [
            'id'            => $report->getHashedKey(),
            'url'           => $report->doc?->getTemporaryUrl(now()->addHour()),
            'media_id'      => $report->doc?->getHashedKey(),
            'extension'     => $report->doc?->getExtensionAttribute(),
            'filename'      => $report->filename,
            'type'          => $report->type,
            'status'        => $report->status,
            'created_at'    => $report->created_at,
        ];
    }

    public function includeContracts(ClientReportsDoc $report): FractalCollection
    {
        return $this->collection($report->contracts, new ClientReportTransformer());
    }
}

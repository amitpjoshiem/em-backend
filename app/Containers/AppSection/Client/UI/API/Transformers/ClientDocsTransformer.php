<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\UI\API\Transformers;

use App\Containers\AppSection\Client\Data\Transporters\OutputClientDocsTransporter;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Collection;

class ClientDocsTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'documents',
    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(OutputClientDocsTransporter $doc): array
    {
        return [
            'status'            => $doc->status,
        ];
    }

    public function includeDocuments(OutputClientDocsTransporter $doc): Collection
    {
        return $this->collection($doc->documents, new DocsTransformer(), 'docs');
    }
}

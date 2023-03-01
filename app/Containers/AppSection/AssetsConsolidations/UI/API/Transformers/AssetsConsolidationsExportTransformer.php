<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\UI\API\Transformers;

use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsExport;
use App\Containers\AppSection\Media\Traits\IncludeMediaModelTransformerTrait;
use App\Ship\Parents\Transformers\Transformer;

class AssetsConsolidationsExportTransformer extends Transformer
{
    use IncludeMediaModelTransformerTrait;

    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'media',
    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function __construct()
    {
        $this->withMediaExpiration = true; // If true then media create sign url. (for AWS S3)
    }

    public function transform(AssetsConsolidationsExport $assetsConsolidationsExport): array
    {
        return [
            'id'          => $assetsConsolidationsExport->getHashedKey(),
            'filename'    => $assetsConsolidationsExport->filename,
            'status'      => $assetsConsolidationsExport->status,
            'type'        => $assetsConsolidationsExport->type,
            'member_id'   => $assetsConsolidationsExport->member->getHashedKey(),
            'member_name' => $assetsConsolidationsExport->member->name,
            'created_at'  => $assetsConsolidationsExport->created_at,
        ];
    }
}

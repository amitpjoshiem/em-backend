<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\UI\API\Transformers;

use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\OutputAssetsConsolidationsTableTransporter;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Collection as FractalCollection;

class AssetsConsolidationsTableTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'assets_consolidations',
    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(OutputAssetsConsolidationsTableTransporter $assetsConsolidationsTable): array
    {
        return [
            'table'    => $assetsConsolidationsTable->tableHashId,
            'name'     => $assetsConsolidationsTable->name,
            'wrap_fee' => $this->formatRoundItemResponse($assetsConsolidationsTable->wrap_fee),
        ];
    }

    public function includeAssetsConsolidations(OutputAssetsConsolidationsTableTransporter $assetsConsolidationsTable): FractalCollection
    {
        return $this->collection($assetsConsolidationsTable->tableData, new AssetsConsolidationsTransformer(), resourceKey: 'AssetsConsolidations');
    }

    private function formatRoundItemResponse(?float $item, bool $isPercent = true): float|string|null
    {
        if ($item !== null) {
            if ($isPercent) {
                $item *= 100;
            }

            $item = round(($item), 2);
        }

        return $item;
    }
}

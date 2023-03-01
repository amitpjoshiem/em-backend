<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\UI\API\Transformers;

use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\OutputAssetsConsolidationsTransporter;
use App\Ship\Parents\Transformers\Transformer;

class AssetsConsolidationsTransformer extends Transformer
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

    public function transform(OutputAssetsConsolidationsTransporter $assetsconsolidations): array
    {
        return [
            'id'                    => $assetsconsolidations->hashId,
            'name'                  => $assetsconsolidations->name,
            'percent_of_holdings'   => $this->formatRoundItemResponse($assetsconsolidations->percent_of_holdings),
            'amount'                => $this->formatRoundItemResponse($assetsconsolidations->amount, false),
            'management_expense'    => $this->formatRoundItemResponse($assetsconsolidations->management_expense),
            'turnover'              => $this->formatRoundItemResponse($assetsconsolidations->turnover),
            'trading_cost'          => $this->formatRoundItemResponse($assetsconsolidations->trading_cost),
            'wrap_fee'              => $this->formatRoundItemResponse($assetsconsolidations->wrap_fee),
            'total_cost_percent'    => $this->formatRoundItemResponse($assetsconsolidations->total_cost_percent),
            'total_cost'            => $this->formatRoundItemResponse($assetsconsolidations->total_cost, false),
        ];
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

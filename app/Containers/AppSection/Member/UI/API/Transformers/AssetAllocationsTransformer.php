<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Transformers;

use App\Containers\AppSection\Member\Models\MemberAssetAllocation;
use App\Ship\Parents\Transformers\Transformer;

class AssetAllocationsTransformer extends Transformer
{
    public function transform(MemberAssetAllocation $assetAllocation): array
    {
        $liquidity = $assetAllocation->liquidity;
        $growth    = $assetAllocation->growth;
        $income    = $assetAllocation->income;
        $total     = (int)$liquidity + (int)$growth + (int)$income;

        return [
            'liquidity' => $liquidity === null ? null : round($liquidity, 3),
            'growth'    => $growth === null ? null : round($growth, 3),
            'income'    => $income === null ? null : round($income, 3),
            'total'     => round($total, 3),
        ];
    }
}

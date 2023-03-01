<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\UI\API\Transformers;

use App\Containers\AppSection\Blueprint\Models\BlueprintNetWorth;
use App\Ship\Parents\Transformers\Transformer;

class BlueprintNetWorthTransformer extends Transformer
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

    public function transform(BlueprintNetWorth $blueprint): array
    {
        $market      = $blueprint->market      ?? 0;
        $liquid      = $blueprint->liquid      ?? 0;
        $income_safe = $blueprint->income_safe ?? 0;
        $sum         = $market + $liquid + $income_safe;

        return [
            'market'        => $this->calculatePercentage($sum, $blueprint->market),
            'liquid'        => $this->calculatePercentage($sum, $blueprint->liquid),
            'income_safe'   => $this->calculatePercentage($sum, $blueprint->income_safe),
            'total'         => $sum,
        ];
    }

    private function calculatePercentage(float $sum, ?float $amount): array
    {
        if ($amount === null) {
            return [
                'amount'    => $amount,
                'percent'   => 0,
            ];
        }

        $percent = empty($sum) ? 0 : round($amount / $sum * 100, 2);

        return [
            'amount'    => $amount,
            'percent'   => $percent,
        ];
    }
}

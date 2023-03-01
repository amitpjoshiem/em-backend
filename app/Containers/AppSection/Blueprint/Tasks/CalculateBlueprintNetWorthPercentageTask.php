<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Tasks;

use App\Containers\AppSection\Blueprint\Models\BlueprintNetworth;
use App\Ship\Parents\Tasks\Task;

class CalculateBlueprintNetWorthPercentageTask extends Task
{
    public function run(?BlueprintNetworth $data): array
    {
        $market      = $data?->market      ?? 0;
        $liquid      = $data?->liquid      ?? 0;
        $income_safe = $data?->income_safe ?? 0;
        $sum         = $market + $liquid + $income_safe;
        $result      = [
            'market' => [
                'amount'     => $market,
                'percentage' => null,
            ],
            'income_safe' => [
                'amount'     => $income_safe,
                'percentage' => null,
            ],
            'liquid' => [
                'amount'     => $liquid,
                'percentage' => null,
            ],
        ];
        foreach ($result as &$field) {
            $field['percentage'] = empty($sum) ? 0 : round($field['amount'] / $sum * 100, 2);
        }

        $result['sum'] = $sum;

        return $result;
    }
}

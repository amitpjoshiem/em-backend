<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\UI\API\Transformers;

use App\Containers\AppSection\MonthlyExpense\Data\Enums\MonthlyExpenseEnum;
use App\Containers\AppSection\MonthlyExpense\Models\MonthlyExpense;
use App\Ship\Parents\Transformers\Transformer;
use stdClass;

class MonthlyExpenseTransformer extends Transformer
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

    public function transform(stdClass $monthlyExpenses): array
    {
        $monthlyExpenses  = (array)$monthlyExpenses;
        $essentialSum     = 0;
        $discretionarySum = 0;
        $data             = [];
        /**
         * @var string         $group
         * @var string | array $values
         */
        foreach (MonthlyExpenseEnum::values() as $group => $values) {
            if (\is_array($values)) {
                foreach ($values as $item) {
                    $data[$group][$item] = [
                        'essential'     => $monthlyExpenses[$group][$item]['essential'] ?? null,
                        'discretionary' => $monthlyExpenses[$group][$item]['discretionary'] ?? null,
                    ];
                    $essentialSum     += $monthlyExpenses[$group][$item]['essential']         ?? 0;
                    $discretionarySum += $monthlyExpenses[$group][$item]['discretionary']     ?? 0;
                }
            } else {
                $data[$values] = [
                    'essential'     => $monthlyExpenses[MonthlyExpense::OTHER_GROUP][$values]['essential'] ?? null,
                    'discretionary' => $monthlyExpenses[MonthlyExpense::OTHER_GROUP][$values]['discretionary'] ?? null,
                ];
                $essentialSum     += $monthlyExpenses[MonthlyExpense::OTHER_GROUP][$values]['essential']         ?? 0;
                $discretionarySum += $monthlyExpenses[MonthlyExpense::OTHER_GROUP][$values]['discretionary']     ?? 0;
            }
        }

        $data['subtotal']['essential']     = $essentialSum;
        $data['subtotal']['discretionary'] = $discretionarySum;
        $data['total']                     = $essentialSum + $discretionarySum;

        return $data;
    }
}

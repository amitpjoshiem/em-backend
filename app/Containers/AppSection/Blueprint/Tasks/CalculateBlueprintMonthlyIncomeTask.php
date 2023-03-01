<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Tasks;

use App\Containers\AppSection\Blueprint\Data\Transporters\OutputBlueprintMonthlyIncomeTransporter;
use App\Containers\AppSection\Blueprint\Models\BlueprintMonthlyIncome;
use App\Ship\Parents\Tasks\Task;

class CalculateBlueprintMonthlyIncomeTask extends Task
{
    /**
     * @var string[]
     */
    private const TOTAL_FIELDS = [
        'current_member',
        'current_spouse',
        'current_pensions',
        'current_rental_income',
        'current_investment',
        'future_member',
        'future_spouse',
        'future_pensions',
        'future_rental_income',
        'future_investment',
    ];

    /**
     * @var string[]
     */
    private const MONTHLY_EXPENSES_FIELDS = [
        'tax',
        'ira_first',
        'ira_second',
    ];

    public function run(?BlueprintMonthlyIncome $data): OutputBlueprintMonthlyIncomeTransporter
    {
        if ($data === null) {
            $data = new BlueprintMonthlyIncome();
        }

        $total = 0;
        foreach (self::TOTAL_FIELDS as $field) {
            $total += $data->{$field};
        }

        $monthlyExpenses = 0;
        foreach (self::MONTHLY_EXPENSES_FIELDS as $field) {
            $monthlyExpenses += $data->{$field};
        }

        return new OutputBlueprintMonthlyIncomeTransporter(array_merge($data->toArray(), [
            'total'             => $total,
            'monthly_expenses'  => $monthlyExpenses,
        ]));
    }
}

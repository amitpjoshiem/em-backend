<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\SubActions;

use App\Containers\AppSection\MonthlyExpense\Data\Transporters\GetMonthlyExpensesTransporter;
use App\Containers\AppSection\MonthlyExpense\Tasks\GetMonthlyExpensesTask;
use App\Ship\Parents\Actions\SubAction;
use Illuminate\Database\Eloquent\Collection;

class GetMonthlyExpensesSubAction extends SubAction
{
    public function run(int $memberId): object
    {
        /** @var Collection $monthlyExpenses */
        $monthlyExpenses = app(GetMonthlyExpensesTask::class)->filterByMemberId($memberId)->run();

        return (object)$monthlyExpenses->groupBy('group')->map(function (Collection $group): Collection {
            return $group->keyBy('item');
        })->toArray();
    }
}

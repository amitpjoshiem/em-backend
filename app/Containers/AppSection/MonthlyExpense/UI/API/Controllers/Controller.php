<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\UI\API\Controllers;

use App\Containers\AppSection\MonthlyExpense\Actions\GetMonthlyExpensesAction;
use App\Containers\AppSection\MonthlyExpense\Actions\SaveMonthlyExpenseAction;
use App\Containers\AppSection\MonthlyExpense\UI\API\Requests\GetMonthlyExpensesRequest;
use App\Containers\AppSection\MonthlyExpense\UI\API\Requests\SaveMonthlyExpenseRequest;
use App\Containers\AppSection\MonthlyExpense\UI\API\Transformers\MonthlyExpenseTransformer;
use App\Ship\Parents\Controllers\ApiController;

class Controller extends ApiController
{
    public function saveMonthlyExpense(SaveMonthlyExpenseRequest $request): array
    {
        $monthlyExpense = app(SaveMonthlyExpenseAction::class)->run($request->getInputByKey('member_id'), $request->except(['member_id', 'subtotal', 'total']));

        return $this->transform($monthlyExpense, MonthlyExpenseTransformer::class, resourceKey: 'monthlyExpense');
    }

    public function getMonthlyExpenses(GetMonthlyExpensesRequest $request): array
    {
        $monthlyExpenses = app(GetMonthlyExpensesAction::class)->run($request->toTransporter());

        return $this->transform($monthlyExpenses, MonthlyExpenseTransformer::class, resourceKey: 'monthlyExpense');
    }
}

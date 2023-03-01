<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\Actions;

use App\Containers\AppSection\MonthlyExpense\Data\Transporters\GetMonthlyExpensesTransporter;
use App\Containers\AppSection\MonthlyExpense\SubActions\GetMonthlyExpensesSubAction;
use App\Containers\AppSection\MonthlyExpense\Tasks\GetMonthlyExpensesTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

class GetMonthlyExpensesAction extends Action
{
    public function run(GetMonthlyExpensesTransporter $data): object
    {
        return app(GetMonthlyExpensesSubAction::class)->run($data->member_id);
    }
}

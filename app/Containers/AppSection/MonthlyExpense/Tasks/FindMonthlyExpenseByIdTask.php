<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\Tasks;

use App\Containers\AppSection\MonthlyExpense\Data\Repositories\MonthlyExpenseRepository;
use App\Containers\AppSection\MonthlyExpense\Models\MonthlyExpense;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindMonthlyExpenseByIdTask extends Task
{
    public function __construct(protected MonthlyExpenseRepository $repository)
    {
    }

    public function run(int $id): ?MonthlyExpense
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $exception) {
            throw new NotFoundException(previous: $exception);
        }
    }
}

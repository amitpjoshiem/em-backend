<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\Tasks;

use App\Containers\AppSection\MonthlyExpense\Data\Repositories\MonthlyExpenseRepository;
use App\Containers\AppSection\MonthlyExpense\Models\MonthlyExpense;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateMonthlyExpenseTask extends Task
{
    public function __construct(protected MonthlyExpenseRepository $repository)
    {
    }

    public function run(int $id, array $data): MonthlyExpense
    {
        try {
            return $this->repository->update($data, $id);
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }
}

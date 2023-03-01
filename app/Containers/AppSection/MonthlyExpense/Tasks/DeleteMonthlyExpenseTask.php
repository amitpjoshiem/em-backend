<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\Tasks;

use App\Containers\AppSection\MonthlyExpense\Data\Repositories\MonthlyExpenseRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteMonthlyExpenseTask extends Task
{
    public function __construct(protected MonthlyExpenseRepository $repository)
    {
    }

    public function run(int $id): bool
    {
        try {
            return (bool)$this->repository->delete($id);
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException(previous: $exception);
        }
    }
}

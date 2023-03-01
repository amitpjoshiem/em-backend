<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\Tasks;

use App\Containers\AppSection\MonthlyExpense\Data\Repositories\MonthlyExpenseRepository;
use App\Containers\AppSection\MonthlyExpense\Models\MonthlyExpense;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class SaveMonthlyExpenseTask extends Task
{
    public function __construct(protected MonthlyExpenseRepository $repository)
    {
    }

    public function run(array $data): MonthlyExpense
    {
        try {
            return $this->repository->updateOrCreate([
                'member_id' => $data['member_id'],
                'group'     => $data['group'],
                'item'      => $data['item'],
            ], $data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

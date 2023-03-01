<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\Tasks;

use App\Containers\AppSection\MonthlyExpense\Data\Repositories\MonthlyExpenseRepository;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;

class GetMonthlyExpensesTask extends Task
{
    public function __construct(protected MonthlyExpenseRepository $repository)
    {
    }

    public function run(): Collection
    {
        return $this->repository->all();
    }

    public function filterByMemberId(int $memberId): self
    {
        $this->repository->pushCriteria(new ThisEqualThatCriteria('member_id', $memberId));

        return $this;
    }
}

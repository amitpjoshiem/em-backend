<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Tasks;

use App\Containers\AppSection\Blueprint\Data\Repositories\BlueprintMonthlyIncomeRepository;
use App\Containers\AppSection\Blueprint\Models\BlueprintMonthlyIncome;
use App\Ship\Parents\Tasks\Task;

class GetBlueprintMonthlyIncomeByMemberIdTask extends Task
{
    public function __construct(protected BlueprintMonthlyIncomeRepository $repository)
    {
    }

    public function run(int $member_id): ?BlueprintMonthlyIncome
    {
        return $this->repository->findByField('member_id', $member_id)->first();
    }
}

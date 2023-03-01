<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Tasks;

use App\Containers\AppSection\AssetsIncome\Data\Repositories\AssetsIncomeValueRepository;
use App\Containers\AppSection\AssetsIncome\Models\AssetsIncomeValue;
use App\Ship\Parents\Tasks\Task;

class FindRowTask extends Task
{
    public function __construct(protected AssetsIncomeValueRepository $repository)
    {
    }

    public function run(string $rowName, string $group, int $memberId): ?AssetsIncomeValue
    {
        return $this->repository->findWhere([
            'member_id' => $memberId,
            'group'     => $group,
            'row'       => $rowName,
        ])->first();
    }
}

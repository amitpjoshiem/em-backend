<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Tasks;

use App\Containers\AppSection\AssetsIncome\Data\Repositories\AssetsIncomeValueRepository;
use App\Ship\Parents\Tasks\Task;

class DeleteRowTask extends Task
{
    public function __construct(protected AssetsIncomeValueRepository $repository)
    {
    }

    public function run(string $rowName, string $group, int $memberId): int
    {
        return $this->repository->deleteWhere([
            'member_id' => $memberId,
            'group'     => $group,
            'row'       => $rowName,
        ]);
    }
}

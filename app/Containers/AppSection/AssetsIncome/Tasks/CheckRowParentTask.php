<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Tasks;

use App\Containers\AppSection\AssetsIncome\Data\Repositories\AssetsIncomeValueRepository;
use App\Containers\AppSection\AssetsIncome\Models\AssetsIncomeValue;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class CheckRowParentTask extends Task
{
    public function __construct(private AssetsIncomeValueRepository $repository)
    {
    }

    public function run(string $rowName, string $group, int $memberId): ?string
    {
        $rowName  = $this->getUncountedName($this->toSnake($rowName));
        $likeRows = $this->repository->findWhere([
            ['row', 'LIKE', sprintf('%%%s%%', $rowName)],
            'member_id' => $memberId,
            'group'     => $group,
        ]);

        return $likeRows->first()?->parent;
    }

    private function toSnake(string $rowName): string
    {
        return Str::lower(Str::replace(' ', '_', $rowName));
    }

    private function getUncountedName(string $rowName): string
    {
        return preg_replace('#_\d$#', '', $rowName);
    }
}

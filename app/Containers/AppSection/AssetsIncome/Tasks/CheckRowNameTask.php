<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Tasks;

use App\Containers\AppSection\AssetsIncome\Data\Repositories\AssetsIncomeValueRepository;
use App\Containers\AppSection\AssetsIncome\Models\AssetsIncomeValue;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class CheckRowNameTask extends Task
{
    public function __construct(private AssetsIncomeValueRepository $repository)
    {
    }

    public function run(string $rowName, string $group, int $memberId): string
    {
        $rowName  = $this->getUncountedName($this->toSnake($rowName));
        $likeRows = $this->repository->findWhere([
            ['row', 'LIKE', sprintf('%%%s%%', $rowName)],
            'member_id' => $memberId,
            'group'     => $group,
        ]);

        if ($likeRows->count() === 0) {
            return $rowName;
        }

        return sprintf('%s_%d', $rowName, $this->getLatestNumber($likeRows));
    }

    private function toSnake(string $rowName): string
    {
        return Str::lower(Str::replace(' ', '_', $rowName));
    }

    private function getUncountedName(string $rowName): string
    {
        return preg_replace('#_\d$#', '', $rowName);
    }

    private function getNumber(string $rowName): int
    {
        $match = [];
        preg_match('#_\d$#', $rowName, $match);

        return (int)filter_var($match[0] ?? null, FILTER_SANITIZE_NUMBER_INT);
    }

    private function getLatestNumber(Collection $values): int
    {
        $max = 1;
        /** @var AssetsIncomeValue $value */
        foreach ($values as $value) {
            $number = $this->getNumber($value->row);

            if ($number > $max) {
                $max = $number;
            }
        }

        return $max + 1;
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\Tasks;

use App\Containers\AppSection\Yodlee\Data\Repositories\YodleeAccountsRepository;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class GetGroupedYodleeAccountsTask extends Task
{
    public function __construct(protected YodleeAccountsRepository $repository)
    {
    }

    public function run(array $memberIds): Collection
    {
        $dateRaw = "DATE_FORMAT(created_at, '%Y-%m')";

        return $this->repository
            ->getBuilder()
            ->selectRaw(sprintf('%s as month, sum(balance) as sum', $dateRaw))
            ->whereIn('member_id', $memberIds)
            ->groupByRaw($dateRaw)->get();
    }
}

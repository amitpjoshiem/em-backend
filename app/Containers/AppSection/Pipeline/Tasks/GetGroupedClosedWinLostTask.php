<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\Tasks;

use App\Containers\AppSection\Client\Data\Repositories\ClientRepository;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class GetGroupedClosedWinLostTask extends Task
{
    public function __construct(protected ClientRepository $repository)
    {
    }

    public function run(int $userId, string $type): Collection
    {
        $type    = GetPreparedPipelineData::SORT_TYPES[$type]['db_format'];
        $dateRaw = sprintf("DATE_FORMAT(clients.closed_win_lost, '%s')", $type);

        return $this->repository
            ->getBuilder()
            ->selectRaw(sprintf("%s as period, sum(case when salesforce_opportunities.stage = 'Closed Win' then 1 else 0 end) as win, sum(case when salesforce_opportunities.stage = 'Closed Lost' then 1 else 0 end) as lost", $dateRaw))
            ->join('members', 'clients.member_id', '=', 'members.id')
            ->join('salesforce_opportunities', 'salesforce_opportunities.member_id', '=', 'members.id')
            ->where('members.user_id', '=', $userId)
            ->groupByRaw($dateRaw)->get();
    }
}

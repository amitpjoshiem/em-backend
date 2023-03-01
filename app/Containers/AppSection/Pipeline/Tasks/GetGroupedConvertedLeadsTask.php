<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\Tasks;

use App\Containers\AppSection\Client\Data\Repositories\ClientRepository;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class GetGroupedConvertedLeadsTask extends Task
{
    public function __construct(protected ClientRepository $repository)
    {
    }

    public function run(int $userId, string $type): Collection
    {
        $type    = GetPreparedPipelineData::SORT_TYPES[$type]['db_format'];
        $dateRaw = sprintf("DATE_FORMAT(clients.created_at, '%s')", $type);

        return $this->repository
            ->getBuilder()
            ->selectRaw(sprintf('%s as period, count(clients.id) as count', $dateRaw))
            ->join('members', 'clients.member_id', '=', 'members.id')
            ->where('members.user_id', '=', $userId)
            ->where('members.type', '!=', Member::LEAD)
            ->groupByRaw($dateRaw)->get();
    }
}

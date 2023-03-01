<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\Tasks;

use App\Containers\AppSection\Client\Data\Repositories\ClientRepository;
use App\Containers\AppSection\Client\Models\Client;
use App\Containers\AppSection\Member\Data\Enums\MemberStepsEnum;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class GetGroupedInputLeadsTask extends Task
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
            ->where(function (Builder $query): void {
                $query->where('clients.completed_financial_fact_finder', '!=', Client::NOT_COMPLETED_STEP)
                    ->orWhere('clients.investment_and_retirement_accounts', '!=', Client::NOT_COMPLETED_STEP)
                    ->orWhere('clients.life_insurance_annuity_and_long_terms_care_policies', '!=', Client::NOT_COMPLETED_STEP)
                    ->orWhere('clients.social_security_information', '!=', Client::NOT_COMPLETED_STEP)
                    ->orWhere('members.step', '!=', MemberStepsEnum::DEFAULT);
            })
            ->groupByRaw($dateRaw)->get();
    }
}

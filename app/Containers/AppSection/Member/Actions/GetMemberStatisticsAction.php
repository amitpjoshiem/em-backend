<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Member\Data\Transporters\OutputMemberStatsTransporter;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\GetAllMembersTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

class GetMemberStatisticsAction extends Action
{
    /**
     * @var string[]
     */
    private const TYPES = [
        Member::PRE_LEAD,
        Member::LEAD,
        Member::PROSPECT,
        Member::CLIENT,
    ];

    public function run(): OutputMemberStatsTransporter
    {
        return new OutputMemberStatsTransporter([
            'count'      => $this->getMembersCount(),
            'leadStatus' => $this->getLeadStatus(),
        ]);
    }

    private function getMembersCount(): array
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        /** @var GetAllMembersTask $membersTask */
        $membersTask = app(GetAllMembersTask::class)
            ->addRequestCriteria()
            ->filterByOwner()
            ->filterByCompany($user->company->getKey());

        /** @var Collection $members */
        $members = $membersTask->run(true);

        $members = $members->groupBy('type');

        $count = [];
        $all   = 0;
        foreach (self::TYPES as $type) {
            $count[$type] = $members->get($type)?->count() ?? 0;
            $all += $count[$type];
        }

        $count['all'] = $all;

        return $count;
    }

    private function getLeadStatus(): array
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        /** @var Collection $members */
        $members = app(GetAllMembersTask::class)
            ->filterByType(Member::LEAD)
            ->filterByOwner()
            ->filterByCompany($user->company->getKey())
            ->withRelations(['client.user'])
            ->run(true);

        $members = $members->groupBy(function (Member $member): bool {
            return $member->client?->user->deleted_at === null;
        });

        $active   = $members->get(true)?->count()  ?? 0;
        $inactive = $members->get(false)?->count() ?? 0;

        return [
            Member::ACTIVE_STATUS   => $active,
            Member::INACTIVE_STATUS => $inactive,
            'all'                   => $active + $inactive,
        ];
    }
}

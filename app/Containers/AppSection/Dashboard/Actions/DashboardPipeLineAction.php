<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Dashboard\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Dashboard\Data\Transporters\DashboardPipeLineTransporter;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\GetAllMembersTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetCompanyByHelperOrUserTask;
use App\Containers\AppSection\Yodlee\Exceptions\BaseException;
use App\Containers\AppSection\Yodlee\Tasks\GetYodleeAccountsByMemberIdsTask;
use App\Ship\Parents\Actions\Action;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;
use stdClass;

class DashboardPipeLineAction extends Action
{
    /**
     * @var array<string, string>
     */
    private const PERIOD_FUNCTION = [
        'year'    => 'subYear',
        'quarter' => 'subQuarter',
        'month'   => 'subMonth',
    ];

    public function __construct()
    {
    }

    /**
     * @throws BaseException
     * @throws RepositoryException
     */
    public function run(DashboardPipeLineTransporter $input): stdClass
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();
        /** @var GetAllMembersTask $membersTask */
        $membersTask = app(GetAllMembersTask::class);

        if ($user->hasRole(RolesEnum::ADVISOR)) {
            $membersTask->filterByUser($user->getKey());
        }

        if ($user->hasRole([RolesEnum::CEO, RolesEnum::ADMIN])) {
            $companyId = app(GetCompanyByHelperOrUserTask::class)->run($user);
            $membersTask->filterByCompany($companyId);
        }

        $membersCount    = $membersTask->count();
        $period          = Carbon::now()->{self::PERIOD_FUNCTION[$input->type]}();
        $newMembersCount = $membersTask->filterFromDate($period)->count();

        /** @var Collection $clients */
        $clients = $membersTask
            ->filterByType(Member::CLIENT)
            ->run(true);
        $clientIds         = $clients->pluck('id')->toArray();
        $aumAccountsSum    = app(GetYodleeAccountsByMemberIdsTask::class)->sum()->run($clientIds);
        $newAumAccountsSum = app(GetYodleeAccountsByMemberIdsTask::class)->sum()->filterFromDate($period)->run($clientIds);

        return (object)[
            'members'       => $membersCount,
            'new_members'   => $newMembersCount,
            'new_aum'       => $newAumAccountsSum->first()->sum,
            'aum'           => $aumAccountsSum->first()->sum,
        ];
    }
}

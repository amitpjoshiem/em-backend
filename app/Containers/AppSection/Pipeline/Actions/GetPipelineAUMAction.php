<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\GetAllMembersTask;
use App\Containers\AppSection\Pipeline\Tasks\GetGroupedYodleeAccountsTask;
use App\Containers\AppSection\Pipeline\Tasks\PreparePipelinePeriodDataTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetCompanyByHelperOrUserTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class GetPipelineAUMAction extends Action
{
    public function run(): array
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        $preparedData = app(PreparePipelinePeriodDataTask::class)->run();
        /** @var GetAllMembersTask $clientsTask */
        $clientsTask = app(GetAllMembersTask::class)->filterByType(Member::CLIENT);

        if ($user->hasRole(RolesEnum::ADVISOR)) {
            $clientsTask->filterByUser($user->getKey());
        }

        if ($user->hasRole([RolesEnum::CEO, RolesEnum::ADMIN])) {
            $companyId = app(GetCompanyByHelperOrUserTask::class)->run($user);
            $clientsTask->filterByCompany($companyId);
        }

        /** @var Collection $clients */
        $clients           = $clientsTask->run(true);
        $clientIds         = $clients->pluck('id')->toArray();
        $accounts          = app(GetGroupedYodleeAccountsTask::class)->run($clientIds);
        foreach ($accounts as $account) {
            if (isset($preparedData[$account->month])) {
                $preparedData[$account->month]['amount'] = $account->sum;
            }
        }

        return $preparedData;
    }
}

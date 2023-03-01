<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Pipeline\Tasks\GetGroupedMemberCountTask;
use App\Containers\AppSection\Pipeline\Tasks\PreparePipelinePeriodDataTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetCompanyByHelperOrUserTask;
use App\Ship\Parents\Actions\Action;

class GetPipelineMemberCountAction extends Action
{
    public function run(): array
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        $preparedData        = app(PreparePipelinePeriodDataTask::class)->run();
        /** @var GetGroupedMemberCountTask $groupedMembersCountTask */
        $groupedMembersCountTask = app(GetGroupedMemberCountTask::class);

        if ($user->hasRole(RolesEnum::ADVISOR)) {
            $groupedMembersCountTask->filterByUser($user->getKey());
        }

        if ($user->hasRole([RolesEnum::CEO, RolesEnum::ADMIN])) {
            $companyId = app(GetCompanyByHelperOrUserTask::class)->run($user);
            $groupedMembersCountTask->filterByCompany($companyId);
        }

        $groupedMembersCount = $groupedMembersCountTask->run();
        foreach ($groupedMembersCount as $monthCount) {
            if (isset($preparedData[$monthCount->month])) {
                $preparedData[$monthCount->month]['amount'] = $monthCount->count;
            }
        }

        return $preparedData;
    }
}

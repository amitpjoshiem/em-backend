<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Pipeline\Tasks\GetGroupedMemberRetiredTask;
use App\Containers\AppSection\Pipeline\Tasks\PreparePipelineMemberRetiredPeriodDataTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetCompanyByHelperOrUserTask;
use App\Ship\Parents\Actions\Action;

class GetPipelineMemberRetiredAction extends Action
{
    public function run(): array
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        $preparedPeriod = app(PreparePipelineMemberRetiredPeriodDataTask::class)->run();

        /** @var GetGroupedMemberRetiredTask $retiredGroupedTask */
        $retiredGroupedTask = app(GetGroupedMemberRetiredTask::class);

        if ($user->hasRole(RolesEnum::ADVISOR)) {
            $retiredGroupedTask->filterByUser($user->getKey());
        }

        if ($user->hasRole([RolesEnum::CEO, RolesEnum::ADMIN])) {
            $companyId = app(GetCompanyByHelperOrUserTask::class)->run($user);
            $retiredGroupedTask->filterByCompany($companyId);
        }

        $retiredGrouped = $retiredGroupedTask->run();
        foreach ($retiredGrouped as $group) {
            if (isset($preparedPeriod[$group->month]) && \is_array($preparedPeriod[$group->month])) {
                $preparedPeriod[$group->month]['retired']   = $group->retired;
                $preparedPeriod[$group->month]['employers'] = $group->employers;
            }
        }

        return $preparedPeriod;
    }
}

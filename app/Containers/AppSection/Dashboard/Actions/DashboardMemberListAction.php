<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Dashboard\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Dashboard\Tasks\GetDashboardMemberListTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetCompanyByHelperOrUserTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class DashboardMemberListAction extends Action
{
    public function run(): Collection
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        /** @var GetDashboardMemberListTask $task */
        $task = app(GetDashboardMemberListTask::class)->withMember();

        if ($user->hasRole(RolesEnum::ADVISOR)) {
            $task->filterByUser($user->getKey());
        }

        if ($user->hasRole([RolesEnum::CEO, RolesEnum::ADMIN])) {
            $companyId = app(GetCompanyByHelperOrUserTask::class)->run($user);
            $task->filterByCompany($companyId);
        }

        return $task->run();
    }
}

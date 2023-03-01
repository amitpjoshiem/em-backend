<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\User\Data\Transporters\OutputUsersStatsTransporter;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetAllUsersTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

class GetUsersStatsAction extends Action
{
    public function run(bool $allRoles = false): OutputUsersStatsTransporter
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        /** @var GetAllUsersTask $task */
        $task = app(GetAllUsersTask::class);

        if ($user->hasRole([RolesEnum::CEO, RolesEnum::ADMIN])) {
            $task->filterByCompany($user->company->getKey());
        }

        if (!$allRoles) {
            $task->withRole(RolesEnum::ADVISOR);
        }

        /** @var Collection $users */
        $users = $task->withRoles()->run();

        $usersStats = [
            'all' => $users->count(),
        ];

        $groupedUsers = $users->groupBy(function (User $user): string {
            return $user->roles->first()->name;
        });

        /**
         * @var string     $role
         * @var Collection $group
         */
        foreach ($groupedUsers as $role => $group) {
            $usersStats[$role] = $group->count();
        }

        return new OutputUsersStatsTransporter([
            'users' => $usersStats,
        ]);
    }
}

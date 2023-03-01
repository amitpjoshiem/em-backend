<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\Actions;

use App\Containers\AppSection\Activity\Tasks\GetAllActivitiesTask;
use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetCompanyByHelperOrUserTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetUserActivitiesAction extends Action
{
    public function __construct()
    {
    }

    public function run(): Collection | LengthAwarePaginator
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        /** @var GetAllActivitiesTask $activitiesTask */
        $activitiesTask = app(GetAllActivitiesTask::class)
            ->withRelations(['user'])
            ->addRequestCriteria()
            ->sortByCreatedAt();

        if ($user->hasRole(RolesEnum::ADVISOR)) {
            $activitiesTask->filterByUser($user->getKey());
        }

        if ($user->hasRole([RolesEnum::CEO, RolesEnum::ADMIN])) {
            $companyId = app(GetCompanyByHelperOrUserTask::class)->run($user);
            $activitiesTask->filterByCompany($companyId);
        }

        return $activitiesTask->run();
    }
}

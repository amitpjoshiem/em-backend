<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetAllUsersTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetAssistantAdvisorsAction extends Action
{
    public function run(): Collection | LengthAwarePaginator
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        return app(GetAllUsersTask::class)
            ->filterByIds($user->advisors->pluck('id')->toArray())
            ->withRoles()
            ->withCompany()
            ->withMedia()
            ->ordered()
            ->run();
    }
}

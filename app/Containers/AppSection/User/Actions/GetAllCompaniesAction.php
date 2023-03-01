<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetAllCompaniesTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

class GetAllCompaniesAction extends Action
{
    /**
     * @return Collection|User[]
     */
    public function run(): Collection | array
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        /** @var GetAllCompaniesTask $task */
        $task = app(GetAllCompaniesTask::class)->addRequestCriteria();

        if (!$user->hasRole(RolesEnum::CEO)) {
            $task->filterById($user->company->getKey());
        }

        return $task
            ->run();
    }
}

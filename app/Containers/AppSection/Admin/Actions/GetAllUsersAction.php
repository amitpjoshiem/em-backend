<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetAllUsersTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetAllUsersAction extends Action
{
    public function run(): Collection|LengthAwarePaginator
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        /** @var GetAllUsersTask $usersTask */
        $usersTask = app(GetAllUsersTask::class)->filterByRequestName()->addRequestCriteria(fieldsToDecode: ['id', 'roles.id', 'company.id']);

        if ($user->hasRole([RolesEnum::ADMIN])) {
            $usersTask->filterByCompany($user->company_id);
        }

        return $usersTask
            ->withRoles()
            ->withCompany()
            ->withMedia()
            ->withRelations([
                'assistants',
                'advisors',
                'usersTransferTo.toUser',
                'usersTransferFrom.fromUser',
            ])
            ->run(false);
    }
}

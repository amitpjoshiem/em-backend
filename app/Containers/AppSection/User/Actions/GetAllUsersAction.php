<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetAllUsersTask;
use App\Containers\AppSection\User\Tasks\GetCompanyByHelperOrUserTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetAllUsersAction extends Action
{
    public function __construct()
    {
    }

    public function run(bool $allRoles = false, bool $adminPanel = false): Collection | LengthAwarePaginator
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();
        /** @var GetAllUsersTask $task */
        $task = app(GetAllUsersTask::class);

        if ($user->hasRole([RolesEnum::CEO, RolesEnum::ADMIN]) && !$adminPanel) {
            $companyId = app(GetCompanyByHelperOrUserTask::class)->run($user);
            $task->filterByCompany($companyId);
        }

        if ($user->hasRole(RolesEnum::ASSISTANT)) {
            $task->filterByIds($user->advisors->pluck('id')->toArray());
        }

        if (!$allRoles) {
            $task->withRole(RolesEnum::ADVISOR);
        }

        return $task
            ->addRequestCriteria(fieldsToDecode: ['company.id'])
            ->withRoles()
            ->withCompany()
            ->withMedia()
            ->withRelations(['assistants', 'advisors'])
            ->ordered()
            ->run(false);
    }
}

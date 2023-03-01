<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Data\Transporters\OutputInitTransporter;
use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tasks\GetAllRolesTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetAllCompaniesTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

class GetUserInitAction extends Action
{
    public function run(): OutputInitTransporter
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        /** @var Collection $roles */
        $roles = app(GetAllRolesTask::class)->run(true);

        /** @var GetAllCompaniesTask $companiesTask */
        $companiesTask = app(GetAllCompaniesTask::class);

        if ($user->hasRole([RolesEnum::ADMIN])) {
            $companiesTask->filterById($user->company_id);
        }

        return new OutputInitTransporter([
            'companies' => $companiesTask->run(),
            'roles'     => $roles->filter(function (Role $role): bool {
                return $role->name !== RolesEnum::CLIENT;
            }),
        ]);
    }
}

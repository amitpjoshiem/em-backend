<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetAllCompaniesTask;
use App\Ship\Parents\Actions\SubAction;
use Illuminate\Database\Eloquent\Collection;

class GetAllCompaniesAction extends SubAction
{
    public function run(): Collection|array
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        /** @var GetAllCompaniesTask $companiesTask */
        $companiesTask = app(GetAllCompaniesTask::class);

        if ($user->hasRole([RolesEnum::ADMIN])) {
            $companiesTask->filterById($user->company_id);
        }

        return $companiesTask->run();
    }
}

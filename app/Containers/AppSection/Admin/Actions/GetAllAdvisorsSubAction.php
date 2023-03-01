<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\User\Tasks\GetAllUsersTask;
use App\Ship\Parents\Actions\SubAction;
use Illuminate\Support\Collection;

class GetAllAdvisorsSubAction extends SubAction
{
    public function run(): Collection
    {
        /** @var Collection $users */
        $users = app(GetAllUsersTask::class)->withRole(RolesEnum::ADVISOR)->run(false);

        return $users->groupBy('company_id');
    }
}

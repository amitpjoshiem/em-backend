<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\User\Tasks\GetAllUsersTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetAllClientsAction extends Action
{
    public function run(): Collection | LengthAwarePaginator
    {
        return app(GetAllUsersTask::class)
            ->addRequestCriteria()
            ->withRole(RolesEnum::CLIENT)
            ->ordered()
            ->run();
    }
}

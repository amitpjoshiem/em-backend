<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Actions;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tasks\GetAllRolesTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetAllRolesAction extends Action
{
    /**
     * @psalm-return Collection|LengthAwarePaginator|Role[]
     */
    public function run(): Collection | LengthAwarePaginator | array
    {
        return app(GetAllRolesTask::class)->addRequestCriteria()->withPermissions()->run(true);
    }
}

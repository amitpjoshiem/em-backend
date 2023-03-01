<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Actions;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tasks\GetAllPermissionsTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetAllPermissionsAction extends Action
{
    /**
     * @psalm-return Collection|LengthAwarePaginator|Permission[]
     */
    public function run(): Collection | LengthAwarePaginator | array
    {
        return app(GetAllPermissionsTask::class)->addRequestCriteria()->run(true);
    }
}

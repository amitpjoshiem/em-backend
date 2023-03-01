<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Actions;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tasks\FindPermissionTask;
use App\Containers\AppSection\Authorization\UI\API\Requests\FindPermissionRequest;
use App\Ship\Parents\Actions\Action;

class FindPermissionAction extends Action
{
    public function run(FindPermissionRequest $request): Permission
    {
        return app(FindPermissionTask::class)->run($request->id);
    }
}

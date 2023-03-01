<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Actions;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tasks\CreatePermissionTask;
use App\Containers\AppSection\Authorization\UI\API\Requests\CreatePermissionRequest;
use App\Ship\Parents\Actions\Action;

class CreatePermissionAction extends Action
{
    public function run(CreatePermissionRequest $request): Permission
    {
        $guardName = $request->guard_name ?? config('auth.defaults.guard');

        return app(CreatePermissionTask::class)->run(
            $request->name,
            $request->description,
            $request->display_name,
            $guardName
        );
    }
}

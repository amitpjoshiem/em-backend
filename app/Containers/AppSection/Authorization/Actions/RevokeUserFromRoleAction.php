<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Actions;

use App\Containers\AppSection\Authorization\Tasks\FindRolesTask;
use App\Containers\AppSection\Authorization\Tasks\RemoveUserRoleTask;
use App\Containers\AppSection\Authorization\UI\API\Requests\RevokeUserFromRoleRequest;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Models\UserModel;

class RevokeUserFromRoleAction extends Action
{
    public function run(RevokeUserFromRoleRequest $request): UserModel
    {
        // If user ID is passed then convert it to instance of User (could be user Id Or Model)
        /** @var User $user */
        $user = $request->user_id instanceof UserModel ? $request->user_id : app(FindUserByIdTask::class)->run($request->user_id);

        // Convert to array in case single ID was passed (could be Single Or Multiple Role Ids)
        $rolesIds = (array)$request->roles_ids;

        $roles = app(FindRolesTask::class)->run($rolesIds);

        foreach ($roles->pluck('name')->toArray() as $roleName) {
            app(RemoveUserRoleTask::class)->run($user, $roleName);
        }

        return $user;
    }
}

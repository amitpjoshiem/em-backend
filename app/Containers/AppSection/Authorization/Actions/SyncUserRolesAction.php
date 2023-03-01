<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Actions;

use App\Containers\AppSection\Authorization\Tasks\FindRolesTask;
use App\Containers\AppSection\Authorization\UI\API\Requests\SyncUserRolesRequest;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Models\UserModel;

class SyncUserRolesAction extends Action
{
    public function run(SyncUserRolesRequest $request): UserModel
    {
        // If user ID is passed then convert it to instance of User (could be user Id Or Model)
        /** @var User $user */
        $user = $request->user_id instanceof UserModel ? $request->user_id : app(FindUserByIdTask::class)->run($request->user_id);

        // Convert roles IDs to array (in case single id passed)
        $rolesIds = (array)$request->roles_ids;

        $roles = app(FindRolesTask::class)->run($rolesIds)->all();

        $user->syncRoles($roles);

        $user = $user->fresh(['roles.permissions']);

        // Check is required as this method 'fresh' can return null
        if (!($user instanceof UserModel)) {
            throw new NotFoundException('Don`t find user with this user_id.');
        }

        return $user;
    }
}

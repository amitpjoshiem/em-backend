<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Actions;

use App\Containers\AppSection\Authorization\SubActions\AssignUserToRolesSubAction;
use App\Containers\AppSection\Authorization\UI\API\Requests\AssignUserToRoleRequest;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Models\UserModel;

class AssignUserToRoleAction extends Action
{
    public function run(AssignUserToRoleRequest $request): UserModel
    {
        // If user ID is passed then convert it to instance of User (could be user Id Or Model)
        /** @var User $user */
        $user = $request->user_id instanceof UserModel ? $request->user_id : app(FindUserByIdTask::class)->run($request->user_id);

        // Convert to array in case single ID was passed
        $rolesIds = (array)$request->roles_ids;

        $user = app(AssignUserToRolesSubAction::class)->run($user, $rolesIds);

        $user = $user->fresh(['roles.permissions']);

        if (!($user instanceof UserModel)) {
            throw new NotFoundException('Don`t find user with this user_id.');
        }

        return $user;
    }
}

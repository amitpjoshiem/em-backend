<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Actions;

use App\Containers\AppSection\Authorization\Data\Transporters\AttachPermissionToUserTransporter;
use App\Containers\AppSection\Authorization\Tasks\FindPermissionsTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Models\UserModel;

class AttachPermissionsToUserAction extends Action
{
    public function run(AttachPermissionToUserTransporter $data): UserModel
    {
        /** @var User $user */
        $user = app(FindUserByIdTask::class)->run($data->user_id);

        $permissions = app(FindPermissionsTask::class)->run($data->permissions_ids);

        return $user->givePermissionTo($permissions);
    }
}

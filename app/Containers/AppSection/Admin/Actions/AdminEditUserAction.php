<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Data\Transporters\UserEditTransporter;
use App\Containers\AppSection\Admin\Tasks\AdminEditUserTask;
use App\Containers\AppSection\Authentication\Tasks\LogoutUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Authorization\SubActions\AssignUserToRolesSubAction;
use App\Containers\AppSection\Authorization\SubActions\UnassignedRoleFromUserSubAction;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;

class AdminEditUserAction extends Action
{
    public function run(UserEditTransporter $userData): User
    {
        /** @var User $user */
        $user = app(AdminEditUserTask::class)->run($userData->toArray(), $userData->id);

        if (!$user->hasRole($userData->role)) {
            app(LogoutUserTask::class)->run($user);

            app(UnassignedRoleFromUserSubAction::class)->run($user, RolesEnum::toValues());

            app(AssignUserToRolesSubAction::class)->run($user, [$userData->role]);
        }

        if ($user->hasRole(RolesEnum::ASSISTANT)) {
            $user->advisors()->detach();
            $user->advisors()->attach($userData->advisors);
        }

        return $user;
    }
}

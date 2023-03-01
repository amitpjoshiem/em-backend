<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Data\Seeders;

use App\Containers\AppSection\Authorization\Actions\AttachPermissionsToRoleAction;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Authorization\Data\Transporters\AttachPermissionToRoleTransporter;
use App\Containers\AppSection\Authorization\Tasks\GetPermissionCollectionViaEnumsTask;
use App\Containers\AppSection\Authorization\Tasks\GetPermissionsKeyTask;
use App\Containers\AppSection\User\Data\Enums\UserPermissionEnum;
use App\Ship\Parents\Seeders\Seeder;

class UserPermissionsSeeder_1 extends Seeder
{
    public function run(): void
    {
        // Default Permissions ----------------------------------------------------------
        $list = app(GetPermissionCollectionViaEnumsTask::class)->run(UserPermissionEnum::cases());
        $task = app(GetPermissionsKeyTask::class);

        $advisorModelKeys  = $task->run($list, UserPermissionEnum::PMS_ADVISOR);
        $adminModelKeys    = $task->run($list, exceptPermissions: [UserPermissionEnum::IMPERSONATE_ADMINS]);

        app(AttachPermissionsToRoleAction::class)->run(AttachPermissionToRoleTransporter::fromArrayable(['role_id' => RolesEnum::ADVISOR, 'permissions_ids' => $advisorModelKeys]));
        app(AttachPermissionsToRoleAction::class)->run(AttachPermissionToRoleTransporter::fromArrayable(['role_id' => RolesEnum::ADMIN,    'permissions_ids' => $adminModelKeys]));
        app(AttachPermissionsToRoleAction::class)->run(AttachPermissionToRoleTransporter::fromArrayable(['role_id' => RolesEnum::CEO,    'permissions_ids' => $adminModelKeys]));
    }
}

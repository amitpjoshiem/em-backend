<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Data\Seeders;

use App\Containers\AppSection\Authorization\Actions\AttachPermissionsToRoleAction;
use App\Containers\AppSection\Authorization\Data\Enums\AuthorizationPermissionEnum;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Authorization\Data\Transporters\AttachPermissionToRoleTransporter;
use App\Containers\AppSection\Authorization\Tasks\GetPermissionCollectionViaEnumsTask;
use App\Containers\AppSection\Authorization\Tasks\GetPermissionsKeyTask;
use App\Ship\Parents\Seeders\Seeder;

class AuthorizationPermissionsSeeder_2 extends Seeder
{
    public function run(): void
    {
        // Default Permissions ----------------------------------------------------------
        $list = app(GetPermissionCollectionViaEnumsTask::class)->run(AuthorizationPermissionEnum::cases());
        $task = app(GetPermissionsKeyTask::class);

        $adminModelKeys = $task->run($list);

        app(AttachPermissionsToRoleAction::class)->run(AttachPermissionToRoleTransporter::fromArrayable(['role_id' => RolesEnum::ADMIN, 'permissions_ids' => $adminModelKeys]));
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Data\Seeders;

use App\Containers\AppSection\Authorization\Actions\AttachPermissionsToRoleAction;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Authorization\Data\Transporters\AttachPermissionToRoleTransporter;
use App\Containers\AppSection\Authorization\Tasks\GetPermissionCollectionViaEnumsTask;
use App\Containers\AppSection\Authorization\Tasks\GetPermissionsKeyTask;
use App\Containers\AppSection\Media\Data\Enums\MediaPermissionEnum;
use App\Ship\Parents\Seeders\Seeder;

class MediaPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Default Permissions ----------------------------------------------------------
        $list = app(GetPermissionCollectionViaEnumsTask::class)->run(MediaPermissionEnum::cases());
        $task = app(GetPermissionsKeyTask::class);

        $investorModelKeys = $task->run($list);
        $adminModelKeys    = $task->run($list);

        app(AttachPermissionsToRoleAction::class)->run(AttachPermissionToRoleTransporter::fromArrayable(['role_id' => RolesEnum::ADVISOR, 'permissions_ids' => $investorModelKeys]));
        app(AttachPermissionsToRoleAction::class)->run(AttachPermissionToRoleTransporter::fromArrayable(['role_id' => RolesEnum::ADMIN,    'permissions_ids' => $adminModelKeys]));
    }
}

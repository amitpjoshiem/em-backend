<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Data\Seeders;

use App\Containers\AppSection\Authorization\Actions\AttachPermissionsToUserAction;
use App\Containers\AppSection\Authorization\Data\Transporters\AttachPermissionToUserTransporter;
use App\Containers\AppSection\User\Data\Enums\UserPermissionEnum;
use App\Ship\Parents\Seeders\Seeder;

class UserPermissionsSeeder_10 extends Seeder
{
    public function run(): void
    {
        $data = AttachPermissionToUserTransporter::fromArrayable([
            'user_id'         => 1,
            'permissions_ids' => [UserPermissionEnum::IMPERSONATE_ADMINS],
        ]);

        app(AttachPermissionsToUserAction::class)->run($data);
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Data\Seeders;

use App\Containers\AppSection\Authorization\Actions\CreateRoleByEnumAction;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Ship\Parents\Seeders\Seeder;

class AuthorizationRolesSeeder_1 extends Seeder
{
    public function run(): void
    {
        // Default Roles ----------------------------------------------------------------
        app(CreateRoleByEnumAction::class)->run(RolesEnum::advisor());
        app(CreateRoleByEnumAction::class)->run(RolesEnum::client());
        app(CreateRoleByEnumAction::class)->run(RolesEnum::lead());
        app(CreateRoleByEnumAction::class)->run(RolesEnum::ceo());
        app(CreateRoleByEnumAction::class)->run(RolesEnum::admin());
        app(CreateRoleByEnumAction::class)->run(RolesEnum::assistant());
        app(CreateRoleByEnumAction::class)->run(RolesEnum::support());
    }
}

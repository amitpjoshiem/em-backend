<?php

namespace App\Ship\Seeders;

use App\Containers\AppSection\Activity\Data\Seeders\UserActivitySeeder_5;
use App\Containers\AppSection\Authorization\Data\Seeders\AuthorizationDefaultUsersSeeder_3;
use App\Containers\AppSection\Authorization\Data\Seeders\AuthorizationDefaultEMUsersSeeder_1;
use App\Containers\AppSection\Authorization\Data\Seeders\AuthorizationPermissionsSeeder_2;
use App\Containers\AppSection\Authorization\Data\Seeders\AuthorizationRolesSeeder_1;

use App\Containers\AppSection\Yodlee\Data\Seeders\YodleeAccountsSeeder_6;
use App\Ship\Parents\Seeders\Seeder;

class SeedTestingData extends Seeder
{
    /**
     * Note: This seeder is not loaded automatically by Apiato
     * This is a special seeder which can be called by "apiato:seed-test" command
     * It is useful for seeding testing data.
     */
    public function run(): void
    {
        app(AuthorizationRolesSeeder_1::class)->run();
        app(AuthorizationPermissionsSeeder_2::class)->run();
        app(AuthorizationDefaultUsersSeeder_3::class)->run();
        app(AuthorizationDefaultEMUsersSeeder_1::class)->run();
        // Create Testing data for live tests
    }
}

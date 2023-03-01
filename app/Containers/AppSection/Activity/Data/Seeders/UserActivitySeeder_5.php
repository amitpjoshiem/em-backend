<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\Data\Seeders;

use App\Containers\AppSection\Activity\Models\UserActivity;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Seeders\Seeder;
use DB;

class UserActivitySeeder_5 extends Seeder
{
    public function run(): void
    {
        if (app()->runningUnitTests() || !config('app.is_development')) {
            return;
        }

        DB::beginTransaction();
        foreach (User::all() as $user) {
            UserActivity::factory()->count(4)->create([
                'user_id' => $user->getKey(),
            ]);
        }

        DB::commit();
    }
}

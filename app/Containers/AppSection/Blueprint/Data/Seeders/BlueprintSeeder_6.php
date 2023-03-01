<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Data\Seeders;

use App\Containers\AppSection\Blueprint\Models\BlueprintConcern;
use App\Containers\AppSection\Blueprint\Models\BlueprintMonthlyIncome;
use App\Containers\AppSection\Blueprint\Models\BlueprintNetworth;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Parents\Seeders\Seeder;
use Illuminate\Support\Facades\DB;

class BlueprintSeeder_6 extends Seeder
{
    public function run(): void
    {
        if (app()->runningUnitTests()) {
            return;
        }

        DB::beginTransaction();
        /** @var Member $member */
        foreach (Member::all() as $member) {
            BlueprintConcern::factory()->create([
                'member_id' => $member->getKey(),
            ]);
            BlueprintMonthlyIncome::factory()->create([
                'member_id' => $member->getKey(),
            ]);
            BlueprintNetworth::factory()->create([
                'member_id' => $member->getKey(),
            ]);
        }

        DB::commit();
    }
}

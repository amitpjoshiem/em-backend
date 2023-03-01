<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Dashboard\Data\Seeders;

use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Ship\Parents\Seeders\Seeder;
use DB;

class DashboardOpportunitySeeder_6 extends Seeder
{
    public function run(): void
    {
        if (app()->runningUnitTests()) {
            return;
        }

        $members = Member::all();
        DB::beginTransaction();
        foreach ($members as $member) {
            SalesforceChildOpportunity::factory()->count(5)->create([
                'user_id'   => $member->user_id,
                'member_id' => $member->getKey(),
            ]);
        }

        DB::commit();
    }
}

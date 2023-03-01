<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Data\Seeders;

use App\Containers\AppSection\ClientReport\Models\ClientReport;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Parents\Seeders\Seeder;
use DB;

class ClientReportsSeeder_5 extends Seeder
{
    public function run(): void
    {
        if (app()->runningUnitTests()) {
            return;
        }

        DB::beginTransaction();
        Member::all()->each(function (Member $member): void {
            if ($member->type === Member::CLIENT) {
                ClientReport::factory()->count(10)->create([
                    'member_id' => $member->getKey(),
                ]);
            }
        });
        DB::commit();
    }
}

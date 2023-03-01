<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Seeders;

use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Models\MemberContact;
use App\Containers\AppSection\Member\Models\MemberEmploymentHistory;
use App\Containers\AppSection\Member\Models\MemberHouse;
use App\Containers\AppSection\Member\Models\MemberOther;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Seeders\Seeder;
use Illuminate\Support\Facades\DB;

class MemberSeeder_4 extends Seeder
{
    public function run(): void
    {
        if (app()->runningUnitTests() || !config('app.is_development')) {
            return;
        }

        /** @var User $user */
        foreach (User::all() as $user) {
            DB::beginTransaction();
            Member::factory()->count(2)->create([
                'user_id'   => $user->getKey(),
            ])->each(
                function (Member $member): void {
                    MemberHouse::factory()->create(['member_id' => $member->getKey()]);
                    MemberEmploymentHistory::factory()->count(random_int(2, 5))->create([
                        'memberable_id'     => $member->getKey(),
                        'memberable_type'   => Member::class,
                    ]);
                    MemberOther::factory()->create(['member_id' => $member->getKey()]);

                    if ($member->married) {
                        $spouse = MemberContact::factory()->create([
                            'member_id' => $member->getKey(),
                            'is_spouse' => true,
                        ]);
                        MemberEmploymentHistory::factory()->count(random_int(2, 5))->create([
                            'memberable_id'     => $spouse->getKey(),
                            'memberable_type'   => MemberContact::class,
                        ]);
                    }

                    MemberContact::factory()->count(5)->create([
                        'member_id' => $member->getKey(),
                        'is_spouse' => false,
                    ]);
                }
            );
            DB::commit();
        }
    }
}

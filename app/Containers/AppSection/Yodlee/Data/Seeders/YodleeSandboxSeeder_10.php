<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Data\Seeders;

use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\Yodlee\Tasks\SaveYodleeMemberTask;
use App\Ship\Parents\Seeders\Seeder;

class YodleeSandboxSeeder_10 extends Seeder
{
    public function run(): void
    {
        if (app()->runningUnitTests()) {
            return;
        }

        if (config('appSection-yodlee.sandbox.env')) {
            /** @var array $yodleeUsers */
            $yodleeUsers = config('appSection-yodlee.sandbox.users');
            $users       = User::all();
            /** @var User $user */
            foreach ($users as $user) {
                /** Our Sandbox Yodlee Default Users Have id from 10304839 to 10304843 */
                $id = 10_304_839;
                foreach ($yodleeUsers as $name => $loginName) {
                    /** @var Member $member */
                    $member = Member::factory()->create([
                        'name'      => $user->getKey() . ' Yodlee ' . $name,
                        'married'   => false,
                        'user_id'   => $user->getKey(),
                    ]);
                    app(SaveYodleeMemberTask::class)->run([
                        'member_id'  => $member->getKey(),
                        'yodlee_id'  => $id,
                        'login_name' => $loginName,
                    ], $member->getKey());
                    /** @noRector \Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector */
                    $id++;
                }
            }
        }
    }
}

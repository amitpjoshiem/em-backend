<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Data\Seeders;

use App\Containers\AppSection\Member\Data\Enums\MemberStepsEnum;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\GetMemberStepOrder;
use App\Containers\AppSection\Yodlee\Models\YodleeAccounts;
use App\Ship\Parents\Seeders\Seeder;
use Illuminate\Support\Facades\DB;

class YodleeAccountsSeeder_6 extends Seeder
{
    public function run(): void
    {
        if (app()->runningUnitTests()) {
            return;
        }

        $assetsAccountsStep = app(GetMemberStepOrder::class)->run(MemberStepsEnum::ASSETS_ACCOUNTS);
        DB::beginTransaction();
        /** @var Member $member */
        foreach (Member::all() as $member) {
            $currentStepCount = app(GetMemberStepOrder::class)->run($member->step);

            if ($currentStepCount >= $assetsAccountsStep) {
                YodleeAccounts::factory()->count(5)->create(['member_id' => $member->getKey()]);
            }
        }

        DB::commit();
    }
}

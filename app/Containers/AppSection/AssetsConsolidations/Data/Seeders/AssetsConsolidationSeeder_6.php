<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Data\Seeders;

use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidations;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsTable;
use App\Containers\AppSection\Member\Data\Enums\MemberStepsEnum;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\GetMemberStepOrder;
use App\Ship\Parents\Seeders\Seeder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AssetsConsolidationSeeder_6 extends Seeder
{
    public function run(): void
    {
        if (app()->runningUnitTests()) {
            return;
        }

        $assetsConsolidationStep = app(GetMemberStepOrder::class)->run(MemberStepsEnum::ASSETS_CONSOLIDATION);
        DB::beginTransaction();
        /** @var Member $member */
        foreach (Member::all() as $member) {
            $currentStepCount = app(GetMemberStepOrder::class)->run($member->step);

            if ($currentStepCount >= $assetsConsolidationStep) {
                /** @var Collection $tables */
                $tables = AssetsConsolidationsTable::factory()->count(random_int(2, 5))->create(['member_id' => $member->getKey()]);
                $tables->each(function (AssetsConsolidationsTable $table) use ($member): void {
                    AssetsConsolidations::factory()->count(random_int(5, config('appSection-assetsConsolidations.table_rows')))->create([
                        'member_id' => $member->getKey(),
                        'table_id'  => $table->getKey(),
                    ]);
                });
            }
        }

        DB::commit();
    }
}

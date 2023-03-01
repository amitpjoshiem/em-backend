<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Actions;

use App\Containers\AppSection\AssetsIncome\Data\Transporters\ConfirmDataTransporter;
use App\Containers\AppSection\Member\Data\Enums\MemberStepsEnum;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Member\Tasks\GetMemberStepOrder;
use App\Containers\AppSection\Member\Tasks\UpdateMemberTask;
use App\Ship\Parents\Actions\Action;

class ConfirmDataAction extends Action
{
    public function run(ConfirmDataTransporter $data): void
    {
        /** @var Member $member */
        $member           = app(FindMemberByIdTask::class)->run($data->member_id);
        $currentStepCount = app(GetMemberStepOrder::class)->run($member->step);
        $assetsIncomeStep = app(GetMemberStepOrder::class)->run(MemberStepsEnum::ASSETS_INCOME);

        if ($currentStepCount < $assetsIncomeStep) {
            app(UpdateMemberTask::class)->run($member->getKey(), ['step' => MemberStepsEnum::ASSETS_INCOME]);
        }
    }
}

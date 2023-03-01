<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions;

use App\Containers\AppSection\Member\Data\Enums\MemberStepsEnum;
use App\Containers\AppSection\Member\Data\Transporters\ConfirmMemberAssetsAccountsTransporter;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Member\Tasks\GetMemberStepOrder;
use App\Containers\AppSection\Member\Tasks\UpdateMemberTask;
use App\Ship\Parents\Actions\Action;

class ConfirmMemberAssetsAccountsAction extends Action
{
    public function run(ConfirmMemberAssetsAccountsTransporter $input): void
    {
        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->run($input->member_id);

        $currentStepCount   = app(GetMemberStepOrder::class)->run($member->step);
        $assetsAccountsStep = app(GetMemberStepOrder::class)->run(MemberStepsEnum::ASSETS_ACCOUNTS);

        if ($currentStepCount < $assetsAccountsStep) {
            app(UpdateMemberTask::class)->run($member->getKey(), ['step' => MemberStepsEnum::ASSETS_ACCOUNTS]);
        }
    }
}

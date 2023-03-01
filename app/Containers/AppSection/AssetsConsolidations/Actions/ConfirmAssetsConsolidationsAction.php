<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Actions;

use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\ConfirmAssetsConsolidationsTransporter;
use App\Containers\AppSection\Member\Data\Enums\MemberStepsEnum;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Member\Tasks\GetMemberStepOrder;
use App\Containers\AppSection\Member\Tasks\UpdateMemberTask;
use App\Ship\Parents\Actions\Action;

class ConfirmAssetsConsolidationsAction extends Action
{
    public function run(ConfirmAssetsConsolidationsTransporter $input): void
    {
        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->run($input->member_id);

        $currentStepCount        = app(GetMemberStepOrder::class)->run($member->step);
        $assetsConsolidationStep = app(GetMemberStepOrder::class)->run(MemberStepsEnum::ASSETS_CONSOLIDATION);

        if ($currentStepCount < $assetsConsolidationStep) {
            app(UpdateMemberTask::class)->run($member->getKey(), ['step' => MemberStepsEnum::ASSETS_CONSOLIDATION]);
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions;

use App\Containers\AppSection\Member\Data\Enums\MemberStepsEnum;
use App\Containers\AppSection\Member\Data\Transporters\ConfirmStressTestTransporter;
use App\Containers\AppSection\Member\Tasks\UpdateMemberTask;
use App\Ship\Parents\Actions\Action;

class ConfirmStressTestAction extends Action
{
    public function run(ConfirmStressTestTransporter $data): void
    {
        app(UpdateMemberTask::class)->run($data->member_id, [
            'step' => MemberStepsEnum::STRESS_TEST,
        ]);
    }
}

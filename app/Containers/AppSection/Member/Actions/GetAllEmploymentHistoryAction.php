<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions;

use App\Containers\AppSection\Member\Data\Transporters\MemberEmploymentHistoryTransporter;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Ship\Parents\Actions\Action;

class GetAllEmploymentHistoryAction extends Action
{
    public function run(MemberEmploymentHistoryTransporter $input): object
    {
        $member            = app(FindMemberByIdTask::class)->run($input->id);
        $employmentHistory = [
            'member' => $member->employmentHistory,
        ];

        if ($member->married) {
            $employmentHistory['spouse'] = $member->spouse->employmentHistory;
        }

        return (object)$employmentHistory;
    }
}

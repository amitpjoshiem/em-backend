<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\Account;

use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Salesforce\Data\Transporters\AccountTransporters\UpdateSalesforceAccountTransporter;
use App\Ship\Parents\Actions\Action;

class UpdateAccountAction extends Action
{
    public function run(UpdateSalesforceAccountTransporter $input): void
    {
        /** @var Member $member */
        $member  = app(FindMemberByIdTask::class)->run($input->member_id);

        $member->salesforce->api()->update();
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\Account;

use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Salesforce\Data\Transporters\AccountTransporters\DeleteSalesforceAccountTransporter;
use App\Containers\AppSection\Salesforce\Tasks\Account\DeleteSalesforceAccountTask;
use App\Ship\Parents\Actions\Action;

class DeleteAccountAction extends Action
{
    public function run(DeleteSalesforceAccountTransporter $input): void
    {
        $member = app(FindMemberByIdTask::class)->run($input->member_id);

        app(DeleteSalesforceAccountTask::class)->run($member->salesforce);
    }
}

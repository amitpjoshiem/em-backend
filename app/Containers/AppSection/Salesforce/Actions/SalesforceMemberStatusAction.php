<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions;

use App\Containers\AppSection\Salesforce\Data\Transporters\MemberStatusTransporter;
use App\Containers\AppSection\Salesforce\Exceptions\FindSalesforceAccountException;
use App\Containers\AppSection\Salesforce\Tasks\Account\FindSalesforceAccountTask;
use App\Ship\Parents\Actions\Action;

class SalesforceMemberStatusAction extends Action
{
    public function run(MemberStatusTransporter $input): bool
    {
        $status = true;

        try {
            app(FindSalesforceAccountTask::class)->run($input->member_id);
        } catch (FindSalesforceAccountException) {
            $status = false;
        }

        return $status;
    }
}

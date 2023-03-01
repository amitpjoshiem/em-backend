<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions;

use App\Containers\AppSection\Salesforce\Data\Transporters\CancelConvertCloseWinTransporter;
use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Containers\AppSection\Salesforce\Tasks\Opportunity\SaveSalesforceOpportunityTask;
use App\Ship\Parents\Actions\Action;

class CancelConvertCloseWinAction extends Action
{
    public function __construct()
    {
    }

    public function run(CancelConvertCloseWinTransporter $input): SalesforceOpportunity
    {
        return app(SaveSalesforceOpportunityTask::class)->run($input->member_id, [
            'convert_close_win' => false,
        ]);
    }
}

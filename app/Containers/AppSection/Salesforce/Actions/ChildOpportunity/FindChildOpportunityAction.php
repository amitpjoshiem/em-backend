<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\ChildOpportunity;

use App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters\FindSalesforceChildOpportunityTransporter;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity\FindSalesforceChildOpportunityByIdTask;
use App\Ship\Parents\Actions\Action;

class FindChildOpportunityAction extends Action
{
    public function run(FindSalesforceChildOpportunityTransporter $input): ?SalesforceChildOpportunity
    {
        return app(FindSalesforceChildOpportunityByIdTask::class)->run($input->child_opportunity_id);
    }
}

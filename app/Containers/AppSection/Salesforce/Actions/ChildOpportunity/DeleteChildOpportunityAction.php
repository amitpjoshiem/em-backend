<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\ChildOpportunity;

use App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters\DeleteSalesforceChildOpportunityTransporter;
use App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity\DeleteSalesforceChildOpportunityTask;
use App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity\FindSalesforceChildOpportunityBySalesforceIdTask;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Actions\Action;

class DeleteChildOpportunityAction extends Action
{
    public function run(DeleteSalesforceChildOpportunityTransporter $input): void
    {
        $childOpportunity = app(FindSalesforceChildOpportunityBySalesforceIdTask::class)->run($input->child_opportunity_id);

        if ($childOpportunity === null) {
            throw new DeleteResourceFailedException();
        }

        app(DeleteSalesforceChildOpportunityTask::class)->run($childOpportunity);
    }
}

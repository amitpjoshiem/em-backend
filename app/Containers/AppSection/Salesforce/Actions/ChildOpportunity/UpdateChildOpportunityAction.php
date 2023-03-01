<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\ChildOpportunity;

use App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters\SaveSalesforceChildOpportunityTransporter;
use App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters\UpdateSalesforceChildOpportunityTransporter;
use App\Containers\AppSection\Salesforce\Events\Events\SalesforceUpdateChildOpportunityEvent;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity\UpdateSalesforceChildOpportunityTask;
use App\Ship\Parents\Actions\Action;

class UpdateChildOpportunityAction extends Action
{
    public function run(UpdateSalesforceChildOpportunityTransporter $input): SalesforceChildOpportunity
    {
        /** @psalm-suppress InvalidScalarArgument */
        $data = new SaveSalesforceChildOpportunityTransporter($input->except('id')->toArray());
        /** @var SalesforceChildOpportunity $childOpportunity */
        $childOpportunity = app(UpdateSalesforceChildOpportunityTask::class)->run($input->id, $data);

        event(new SalesforceUpdateChildOpportunityEvent($childOpportunity->id));

        return $childOpportunity;
    }
}

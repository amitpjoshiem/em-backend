<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\Opportunity;

use App\Containers\AppSection\Salesforce\Data\Transporters\OpportunityTransporters\CreateSalesforceOpportunityTransporter;
use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\SubActions\Opportunity\CreateOpportunitySubAction;
use App\Ship\Parents\Actions\Action;

class CreateOpportunityAction extends Action
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    /**
     * @throws \App\Containers\AppSection\Salesforce\Exceptions\SalesforceCreateException
     * @throws \App\Ship\Exceptions\CreateResourceFailedException
     * @throws \JsonException
     */
    public function run(CreateSalesforceOpportunityTransporter $input): SalesforceOpportunity
    {
        return app(CreateOpportunitySubAction::class)->run($input);
    }
}

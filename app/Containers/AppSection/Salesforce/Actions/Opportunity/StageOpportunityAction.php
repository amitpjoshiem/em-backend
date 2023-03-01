<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\Opportunity;

use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Ship\Parents\Actions\Action;

class StageOpportunityAction extends Action
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(): object
    {
        return (object)$this->apiService->opportunity()->getStageListValues();
    }
}

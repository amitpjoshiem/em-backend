<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\ChildOpportunity;

use App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters\FindAllSalesforceChildOpportunityTransporter;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity\FindAllSalesforceChildOpportunityTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class FindAllChildOpportunityAction extends Action
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(FindAllSalesforceChildOpportunityTransporter $input): Collection
    {
        return app(FindAllSalesforceChildOpportunityTask::class)->run($input->member_id);
    }
}

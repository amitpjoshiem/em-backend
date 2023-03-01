<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\ChildOpportunity;

use App\Containers\AppSection\Salesforce\Exceptions\SalesforceDescribeException;
use App\Containers\AppSection\Salesforce\Models\SalesforceInit;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Ship\Parents\Actions\Action;
use JsonException;

class InitChildOpportunityAction extends Action
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    /**
     * @throws SalesforceDescribeException
     * @throws JsonException
     */
    public function run(): object
    {
        return (object)[
            'stageList'     => SalesforceInit::getStageList(),
            'typeList'      => SalesforceInit::getTypeList(),
        ];
    }
}

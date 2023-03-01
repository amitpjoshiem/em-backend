<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions;

use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Ship\Parents\Actions\Action;

class ImportAuthenticatedUserInSalesforceAction extends Action
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(int $userId, string $salesforceId): void
    {
    }
}

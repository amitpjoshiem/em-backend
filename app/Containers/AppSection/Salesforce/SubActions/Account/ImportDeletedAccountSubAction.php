<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions\Account;

use App\Containers\AppSection\Salesforce\Models\SalesforceAccount;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\Tasks\Account\DeleteSalesforceAccountTask;
use App\Containers\AppSection\Salesforce\Tasks\Account\FindSalesforceAccountBySalesforceIdTask;
use App\Ship\Parents\Actions\SubAction;
use Carbon\CarbonImmutable;
use function app;

class ImportDeletedAccountSubAction extends SubAction
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        $deleted = $this->apiService->account()->getDeleted($startDate, $endDate);

        if (!isset($deleted['deletedRecords'])) {
            return;
        }

        foreach ($deleted['deletedRecords'] as $item) {
            if (isset($item['id'])) {
                $salesforceId = $item['id'];
                /** @var SalesforceAccount | null $account */
                $account = app(FindSalesforceAccountBySalesforceIdTask::class)->run($salesforceId);

                if ($account !== null) {
                    app(DeleteSalesforceAccountTask::class)->run($account, false);
                }
            }
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\Account\Import;

use App\Containers\AppSection\Salesforce\Actions\GlobalImportObjectInterface;
use App\Containers\AppSection\Salesforce\Models\SalesforceUser;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\SubActions\Account\SaveImportedAccountSubAction;
use App\Containers\AppSection\Salesforce\Tasks\CreateSalesforceTemporaryImportTask;
use App\Containers\AppSection\Salesforce\Tasks\FindAllSalesforceUsersTask;
use App\Ship\Parents\Actions\Action;

class GlobalImportAccountAction extends Action implements GlobalImportObjectInterface
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(): void
    {
        $accounts        = $this->apiService->account()->globalImport();
        $salesforceUsers = app(FindAllSalesforceUsersTask::class)->run()
            ->mapWithKeys(fn (SalesforceUser $item) => [$item->salesforce_id => $item->user_id])
            ->toArray();
        foreach ($accounts['records'] as $account) {
            if ($account['IsDeleted'] === true) {
                continue;
            }

            $userId = $salesforceUsers[$account['OwnerId']] ?? null;

            if ($userId === null) {
                app(CreateSalesforceTemporaryImportTask::class)
                    ->run(SalesforceApiService::ACCOUNT, $account['Id'], $account['OwnerId']);
                continue;
            }

            app(SaveImportedAccountSubAction::class)->run($account, $account['Id'], $userId);
        }
    }
}

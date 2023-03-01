<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions\Account;

use App\Containers\AppSection\Salesforce\Data\Transporters\SaveObjectExceptionTransporter;
use App\Containers\AppSection\Salesforce\Exceptions\ImportExceptions\MultipleExceptions;
use App\Containers\AppSection\Salesforce\Exceptions\ImportExceptions\SaveObjectException;
use App\Containers\AppSection\Salesforce\Models\SalesforceAccount;
use App\Containers\AppSection\Salesforce\Models\SalesforceUser;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\Tasks\CreateSalesforceTemporaryImportTask;
use App\Containers\AppSection\Salesforce\Tasks\FindAllSalesforceUsersTask;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\SubAction;
use Carbon\CarbonImmutable;
use Exception;
use function app;

class ImportUpdatedAccountSubAction extends SubAction
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    /**
     * @throws CreateResourceFailedException
     * @throws MultipleExceptions
     */
    public function run(CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        $importedIds = $this->apiService->account()->getUpdated($startDate, $endDate);

        $exceptions = new MultipleExceptions();

        if (!isset($importedIds['ids'])) {
            return;
        }

        $salesforceUsers = app(FindAllSalesforceUsersTask::class)->run()->mapWithKeys(fn (SalesforceUser $item) => [$item->salesforce_id => $item->user_id])->toArray();

        foreach (array_chunk($importedIds['ids'], 10) as $chunkedImportedIds) {
            $importedData = $this->apiService->account()->findAll($chunkedImportedIds);
            foreach ($importedData as $accountInfo) {
                $userId = $salesforceUsers[$accountInfo['OwnerId']] ?? null;

                if ($userId === null) {
                    app(CreateSalesforceTemporaryImportTask::class)->run(SalesforceApiService::ACCOUNT, $accountInfo['Id'], $accountInfo['OwnerId']);
                    continue;
                }

                try {
                    app(SaveImportedAccountSubAction::class)->run($accountInfo, $accountInfo['Id'], $userId);
                } catch (Exception $exception) {
                    $exceptionDate = new SaveObjectExceptionTransporter([
                        'salesforce_id'  => $accountInfo['Id'],
                        'object'         => SalesforceAccount::class,
                        'salesforceData' => $accountInfo,
                        'exception'      => $exception,
                    ]);
                    $exceptions->addException(new SaveObjectException($exceptionDate));
                }
            }
        }

        if (!$exceptions->getExceptions()->isEmpty()) {
            throw $exceptions;
        }
    }
}

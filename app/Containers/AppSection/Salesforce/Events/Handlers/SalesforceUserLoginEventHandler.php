<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Events\Handlers;

use App\Containers\AppSection\Salesforce\Events\Events\SalesforceUserLoginEvent;
use App\Containers\AppSection\Salesforce\Exceptions\SalesforceFindException;
use App\Containers\AppSection\Salesforce\Models\SalesforceTemporaryImport;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\SubActions\ImportTemporaryObjectSubAction;
use App\Containers\AppSection\Salesforce\Tasks\FindSalesforceTemporaryImportByUserIdTask;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use JsonException;

class SalesforceUserLoginEventHandler implements ShouldQueue
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    /**
     * @throws SalesforceFindException
     * @throws JsonException
     */
    public function handle(SalesforceUserLoginEvent $event): void
    {
        $temporaryObjects = app(FindSalesforceTemporaryImportByUserIdTask::class)->run($event->salesforceUserId);

        /** @var SalesforceTemporaryImport $object */
        foreach ($temporaryObjects as $object) {
            try {
                app(ImportTemporaryObjectSubAction::class)->run($object, $event->userId);
            } catch (Exception $exception) {
                Log::error('Can`t import temporary Object', [
                    'salesforce_ID' => $object->salesforce_id,
                    'message'       => $exception->getMessage(),
                ]);
            }
        }
    }
}

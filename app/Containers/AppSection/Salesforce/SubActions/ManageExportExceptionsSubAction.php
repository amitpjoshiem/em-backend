<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions;

use App\Containers\AppSection\Salesforce\Exceptions\ExportExceptions\ApiRequestException;
use App\Containers\AppSection\Salesforce\Exceptions\ExportExceptions\OwnerNotExistException;
use App\Containers\AppSection\Salesforce\Exceptions\ExportExceptions\SalesforceAuthException;
use App\Containers\AppSection\Salesforce\Tasks\SaveSalesforceExportExceptionTask;
use App\Containers\AppSection\Salesforce\Tasks\SaveSalesforceTemporaryExportTask;
use  App\Containers\AppSection\Telegram\SubActions\SendAlertMessageSubAction;
use  App\Ship\Parents\Actions\SubAction;
use Exception;
use Illuminate\Support\Facades\Log;

class ManageExportExceptionsSubAction extends SubAction
{
    public function run(Exception $exception, string $model, int $modelId, string $action): void
    {
        switch (true) {
            case $exception instanceof ApiRequestException:
                if ($exception->isAuth) {
                    $this->toTemporaryExport($model, $modelId, $action);
                    break;
                }

                $this->saveApiException($exception, $model, $modelId);
                break;
            case $exception instanceof SalesforceAuthException || $exception instanceof OwnerNotExistException:
                $this->toTemporaryExport($model, $modelId, $action);
                break;
            default:
                Log::critical('Unhandled Salesforce Exception', [
                    'message' => $exception->getMessage(),
                    'trace'   => $exception->getTraceAsString(),
                ]);
                break;
        }
    }

    private function toTemporaryExport(string $model, int $modelId, string $action): void
    {
        app(SaveSalesforceTemporaryExportTask::class)->run($model, $modelId, $action);
    }

    private function saveApiException(ApiRequestException $exception, string $objectType, int $objectId): void
    {
        app(SaveSalesforceExportExceptionTask::class)->run($exception, $objectType, $objectId);
        $object  = explode('\\', $objectType);
        $object  = array_pop($object);

        $message = view('appSection@salesforce::salesforce_export_exception', [
            'object'   => $object,
            'objectId' => $objectId,
        ]);
        app(SendAlertMessageSubAction::class)->run($message);
    }
}

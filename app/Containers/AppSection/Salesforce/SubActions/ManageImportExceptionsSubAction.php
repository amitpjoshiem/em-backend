<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions;

use App\Containers\AppSection\Salesforce\Exceptions\ImportExceptions\FindObjectInfoException;
use App\Containers\AppSection\Salesforce\Exceptions\ImportExceptions\MultipleExceptions;
use App\Containers\AppSection\Salesforce\Exceptions\ImportExceptions\SaveObjectException;
use App\Containers\AppSection\Salesforce\Tasks\CheckSalesforceExceptionTask;
use App\Containers\AppSection\Salesforce\Tasks\CreateUnhandledSalesforceExceptionTask;
use App\Containers\AppSection\Salesforce\Tasks\SaveSalesforceExceptionTask;
use App\Containers\AppSection\Salesforce\Tasks\SaveSalesforceFindExceptionTask;
use App\Containers\AppSection\Telegram\SubActions\SendAlertMessageSubAction;
use App\Ship\Core\Abstracts\Exceptions\Exception as CoreException;
use App\Ship\Parents\Actions\SubAction;
use Exception;
use Throwable;

class ManageImportExceptionsSubAction extends SubAction
{
    public function run(Exception $exception): void
    {
        if ($exception instanceof MultipleExceptions) {
            foreach ($exception->getExceptions() as $exception) {
                $this->handleException($exception);
            }
        } else {
            $this->handleException($exception);
        }
    }

    private function handleException(Throwable $exception): void
    {
        if ($exception instanceof SaveObjectException) {
            if (!app(CheckSalesforceExceptionTask::class)->run($exception->data->salesforce_id, $exception->data->object)) {
                $message = match (true) {
                    $exception->data->exception instanceof CoreException => $exception->data->exception->getRootMessage(),
                    default                                              => $exception->data->exception->getMessage(),
                };

                $message = view('appSection@salesforce::salesforce_import_exception', [
                    'object'  => $exception->data->object,
                    'message' => $message,
                ]);
                app(SendAlertMessageSubAction::class)->run($message);
            }

            app(SaveSalesforceExceptionTask::class)->run($exception);
        } elseif ($exception instanceof FindObjectInfoException) {
            if (!app(CheckSalesforceExceptionTask::class)->run($exception->salesforce_id, $exception->object)) {
                $message = view('appSection@salesforce::salesforce_import_exception', [
                    'object'  => $exception->object,
                    'message' => 'Can`t Find Object in Salesforce',
                ]);
                app(SendAlertMessageSubAction::class)->run($message);
            }

            app(SaveSalesforceFindExceptionTask::class)->run($exception);
        } else {
            app(CreateUnhandledSalesforceExceptionTask::class)->run($exception->getTraceAsString(), $exception->getMessage());
        }
    }
}

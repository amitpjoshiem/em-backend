<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Data\Transporters\TryExportExceptionTransporter;
use App\Containers\AppSection\Salesforce\Models\SalesforceExportException;
use App\Containers\AppSection\Salesforce\Models\SalesforceObjectInterface;
use App\Containers\AppSection\Salesforce\Services\Objects\AbstractObject;
use App\Containers\AppSection\Salesforce\Tasks\DeleteSalesforceExportExceptionByIdTasks;
use App\Containers\AppSection\Salesforce\Tasks\FindSalesforceExportExceptionByIdTasks;
use App\Ship\Parents\Actions\SubAction;
use Exception;

class TryExportExceptionAction extends SubAction
{
    /**
     * @throws Exception
     */
    public function run(TryExportExceptionTransporter $data): bool
    {
        /** @var SalesforceExportException $exception */
        $exception = app(FindSalesforceExportExceptionByIdTasks::class)
            ->withRelations(['salesforceObject'])
            ->run($data->export_exceptions_id);

        if ($exception->salesforceObject instanceof SalesforceObjectInterface) {
            $action = match ($exception->method) {
                'post'   => AbstractObject::CREATE,
                'patch'  => AbstractObject::UPDATE,
                'delete' => AbstractObject::DELETE,
            };

            if ($exception->salesforceObject->api()->{$action}()) {
                app(DeleteSalesforceExportExceptionByIdTasks::class)->run($exception->getKey());

                return true;
            }
        }

        return false;
    }
}

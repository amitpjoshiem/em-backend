<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions;

use App\Containers\AppSection\Salesforce\Models\SalesforceTemporaryImport;
use App\Containers\AppSection\Salesforce\SubActions\ImportTemporaryObjectSubAction;
use App\Containers\AppSection\Salesforce\Tasks\FindAllSalesforceTemporaryImportsTask;
use App\Ship\Parents\Actions\Action;

class CheckTemporaryImportAction extends Action
{
    public function __construct()
    {
    }

    public function run(): void
    {
        $temporaryImports = app(FindAllSalesforceTemporaryImportsTask::class)
            ->withRelations(['salesforceUser'])
            ->run()
            ->filter(function (SalesforceTemporaryImport $import): bool {
                return $import->salesforceUser !== null;
            });

        /** @var SalesforceTemporaryImport $temporaryImport */
        foreach ($temporaryImports as $temporaryImport) {
            app(ImportTemporaryObjectSubAction::class)->run($temporaryImport, $temporaryImport->salesforceUser->user_id);
        }
    }
}

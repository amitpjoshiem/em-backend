<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Jobs;

use App\Containers\AppSection\Salesforce\Actions\Account\Import\ImportAccountAction;
use App\Containers\AppSection\Salesforce\Actions\ImportObjectInterface;
use App\Containers\AppSection\Salesforce\Models\SalesforceAccount;

class ImportAccountsJob extends ImportObjectsJob
{
    public function getImportAction(): ImportObjectInterface
    {
        return app(ImportAccountAction::class);
    }

    public static function getObjectName(): string
    {
        return 'Account';
    }

    public static function getObjectModel(): string
    {
        return SalesforceAccount::class;
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Jobs;

use App\Containers\AppSection\Salesforce\Actions\Contact\Import\ImportContactAction;
use App\Containers\AppSection\Salesforce\Actions\ImportObjectInterface;
use App\Containers\AppSection\Salesforce\Models\SalesforceContact;

class ImportContactsJob extends ImportObjectsJob
{
    public function getImportAction(): ImportObjectInterface
    {
        return app(ImportContactAction::class);
    }

    public static function getObjectName(): string
    {
        return 'Contact';
    }

    public static function getObjectModel(): string
    {
        return SalesforceContact::class;
    }
}

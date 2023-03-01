<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Jobs;

use App\Containers\AppSection\Salesforce\Actions\ImportObjectInterface;
use App\Containers\AppSection\Salesforce\Actions\Opportunity\Import\ImportOpportunityAction;
use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;

class ImportOpportunitiesJob extends ImportObjectsJob
{
    public function getImportAction(): ImportObjectInterface
    {
        return app(ImportOpportunityAction::class);
    }

    public static function getObjectName(): string
    {
        return 'Opportunity';
    }

    public static function getObjectModel(): string
    {
        return SalesforceOpportunity::class;
    }
}

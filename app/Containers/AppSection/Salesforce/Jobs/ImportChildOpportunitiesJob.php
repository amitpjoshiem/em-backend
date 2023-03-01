<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Jobs;

use App\Containers\AppSection\Salesforce\Actions\ChildOpportunity\Import\ImportChildOpportunityAction;
use App\Containers\AppSection\Salesforce\Actions\ImportObjectInterface;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;

class ImportChildOpportunitiesJob extends ImportObjectsJob
{
    public function getImportAction(): ImportObjectInterface
    {
        return app(ImportChildOpportunityAction::class);
    }

    public static function getObjectName(): string
    {
        return 'Child Opportunity';
    }

    public static function getObjectModel(): string
    {
        return SalesforceChildOpportunity::class;
    }
}

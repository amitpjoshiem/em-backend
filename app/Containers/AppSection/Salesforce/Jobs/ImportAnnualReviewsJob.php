<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Jobs;

use App\Containers\AppSection\Salesforce\Actions\AnnualReview\Import\ImportAnnualReviewAction;
use App\Containers\AppSection\Salesforce\Actions\ImportObjectInterface;
use App\Containers\AppSection\Salesforce\Models\SalesforceAnnualReview;

class ImportAnnualReviewsJob extends ImportObjectsJob
{
    public function getImportAction(): ImportObjectInterface
    {
        return app(ImportAnnualReviewAction::class);
    }

    public static function getObjectName(): string
    {
        return 'Annual Review';
    }

    public static function getObjectModel(): string
    {
        return SalesforceAnnualReview::class;
    }
}

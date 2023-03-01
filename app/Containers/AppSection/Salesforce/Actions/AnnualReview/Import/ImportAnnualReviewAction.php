<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\AnnualReview\Import;

use App\Containers\AppSection\Salesforce\Actions\ImportObjectInterface;
use App\Containers\AppSection\Salesforce\SubActions\AnnualReview\ImportDeletedAnnualReviewSubAction;
use App\Containers\AppSection\Salesforce\SubActions\AnnualReview\ImportUpdatedAnnualReviewSubAction;
use App\Ship\Parents\Actions\Action;
use Carbon\CarbonImmutable;
use function app;

class ImportAnnualReviewAction extends Action implements ImportObjectInterface
{
    public function run(CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        app(ImportDeletedAnnualReviewSubAction::class)->run($startDate, $endDate);
        app(ImportUpdatedAnnualReviewSubAction::class)->run($startDate, $endDate);
    }
}

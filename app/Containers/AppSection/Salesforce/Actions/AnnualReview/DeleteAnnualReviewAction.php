<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\AnnualReview;

use App\Containers\AppSection\Salesforce\Data\Transporters\AnnualReviewTransporters\DeleteSalesforceAnnualReviewTransporter;
use App\Containers\AppSection\Salesforce\Data\Transporters\AnnualReviewTransporters\FindSalesforceAnnualReviewTransporter;
use App\Containers\AppSection\Salesforce\Tasks\AnnualReview\DeleteSalesforceAnnualReviewTask;
use App\Ship\Parents\Actions\Action;

class DeleteAnnualReviewAction extends Action
{
    public function run(DeleteSalesforceAnnualReviewTransporter $input): void
    {
        $annualReview = app(FindAnnualReviewByIdAction::class)->run(
            new FindSalesforceAnnualReviewTransporter([
                'id' => $input->id,
            ])
        );

        app(DeleteSalesforceAnnualReviewTask::class)->run($annualReview);
    }
}

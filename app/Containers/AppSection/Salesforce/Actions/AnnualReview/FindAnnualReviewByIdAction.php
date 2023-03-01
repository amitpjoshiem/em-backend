<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\AnnualReview;

use App\Containers\AppSection\Salesforce\Data\Transporters\AnnualReviewTransporters\FindSalesforceAnnualReviewTransporter;
use App\Containers\AppSection\Salesforce\Models\SalesforceAnnualReview;
use App\Containers\AppSection\Salesforce\Tasks\AnnualReview\FindSalesforceAnnualReviewsByIdTask;
use App\Ship\Parents\Actions\Action;

class FindAnnualReviewByIdAction extends Action
{
    public function run(FindSalesforceAnnualReviewTransporter $input): SalesforceAnnualReview
    {
        return app(FindSalesforceAnnualReviewsByIdTask::class)->run($input->id);
    }
}

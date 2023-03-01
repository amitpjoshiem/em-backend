<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\AnnualReview;

use App\Containers\AppSection\Salesforce\Data\Transporters\AnnualReviewTransporters\UpdateSalesforceAnnualReviewTransporter;
use App\Containers\AppSection\Salesforce\Models\SalesforceAnnualReview;
use App\Containers\AppSection\Salesforce\Tasks\AnnualReview\UpdateSalesforceAnnualReviewByIdTask;
use App\Ship\Parents\Actions\Action;

class UpdateAnnualReviewAction extends Action
{
    public function run(int $id, UpdateSalesforceAnnualReviewTransporter $input): SalesforceAnnualReview
    {
        $annualReview = app(UpdateSalesforceAnnualReviewByIdTask::class)->run($id, $input);

        $annualReview->api()->update();

        return $annualReview;
    }
}

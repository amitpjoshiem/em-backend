<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\AnnualReview;

use App\Containers\AppSection\Salesforce\Data\Transporters\AnnualReviewTransporters\GetAllSalesforceAnnualReviewForMemberTransporter;
use App\Containers\AppSection\Salesforce\Tasks\AnnualReview\FindSalesforceAnnualReviewsByMemberIdTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetAllAnnualReviewByMemberIdAction extends Action
{
    public function run(GetAllSalesforceAnnualReviewForMemberTransporter $input): Collection|LengthAwarePaginator
    {
        return app(FindSalesforceAnnualReviewsByMemberIdTask::class)->addRequestCriteria()->run($input->member_id);
    }
}

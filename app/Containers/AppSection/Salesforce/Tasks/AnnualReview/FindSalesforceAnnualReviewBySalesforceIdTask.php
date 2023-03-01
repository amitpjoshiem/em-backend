<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\AnnualReview;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceAnnualReviewRepository;
use App\Containers\AppSection\Salesforce\Exceptions\FindSalesforceAccountException;
use App\Containers\AppSection\Salesforce\Models\SalesforceAnnualReview;
use App\Ship\Parents\Tasks\Task;

class FindSalesforceAnnualReviewBySalesforceIdTask extends Task
{
    public function __construct(protected SalesforceAnnualReviewRepository $repository)
    {
    }

    /**
     * @throws FindSalesforceAccountException
     */
    public function run(string $salesforceId): ?SalesforceAnnualReview
    {
        return $this->repository->findByField(['salesforce_id'  => $salesforceId])->first();
    }
}

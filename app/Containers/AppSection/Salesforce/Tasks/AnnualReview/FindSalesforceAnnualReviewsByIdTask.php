<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\AnnualReview;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceAnnualReviewRepository;
use App\Containers\AppSection\Salesforce\Exceptions\FindSalesforceAnnualReviewException;
use App\Containers\AppSection\Salesforce\Models\SalesforceAnnualReview;
use App\Ship\Parents\Tasks\Task;

class FindSalesforceAnnualReviewsByIdTask extends Task
{
    public function __construct(protected SalesforceAnnualReviewRepository $repository)
    {
    }

    /**
     * @throws FindSalesforceAnnualReviewException
     */
    public function run(int $id): SalesforceAnnualReview
    {
        $annualReview = $this->repository->find($id);

        if ($annualReview === null) {
            throw new FindSalesforceAnnualReviewException();
        }

        return $annualReview;
    }
}

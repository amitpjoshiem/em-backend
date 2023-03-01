<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\AnnualReview;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceAnnualReviewRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceAnnualReview;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteSalesforceAnnualReviewTask extends Task
{
    public function __construct(protected SalesforceAnnualReviewRepository $repository)
    {
    }

    /**
     * @throws DeleteResourceFailedException
     */
    public function run(SalesforceAnnualReview $annualReview, bool $withApi = true): bool
    {
        if ($withApi) {
            $annualReview->api()->delete();
        }

        try {
            return (bool)$this->repository->delete($annualReview->getKey());
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException(previous: $exception);
        }
    }
}

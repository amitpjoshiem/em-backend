<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\AnnualReview;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceAnnualReviewRepository;
use App\Containers\AppSection\Salesforce\Data\Transporters\AnnualReviewTransporters\UpdateSalesforceAnnualReviewTransporter;
use App\Containers\AppSection\Salesforce\Models\SalesforceAnnualReview;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateSalesforceAnnualReviewByIdTask extends Task
{
    public function __construct(protected SalesforceAnnualReviewRepository $repository)
    {
    }

    public function run(int $id, UpdateSalesforceAnnualReviewTransporter $data): SalesforceAnnualReview
    {
        try {
            return $this->repository->update($data->toArray(), $id);
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }
}

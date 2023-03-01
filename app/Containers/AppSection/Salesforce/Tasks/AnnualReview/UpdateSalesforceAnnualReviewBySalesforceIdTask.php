<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\AnnualReview;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceAnnualReviewRepository;
use App\Containers\AppSection\Salesforce\Data\Transporters\AnnualReviewTransporters\UpdateSalesforceAnnualReviewTransporter;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class UpdateSalesforceAnnualReviewBySalesforceIdTask extends Task
{
    public function __construct(protected SalesforceAnnualReviewRepository $repository)
    {
    }

    public function run(string $salesforceId, UpdateSalesforceAnnualReviewTransporter $data): Collection|bool
    {
        $this->repository->pushCriteria(new ThisEqualThatCriteria('salesforce_id', $salesforceId));

        try {
            return $this->repository->updateByCriteria($data->toArray());
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }
}

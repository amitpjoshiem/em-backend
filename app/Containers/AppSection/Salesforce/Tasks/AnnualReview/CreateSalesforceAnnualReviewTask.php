<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\AnnualReview;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceAnnualReviewRepository;
use App\Containers\AppSection\Salesforce\Data\Transporters\AnnualReviewTransporters\CreateSalesforceAnnualReviewTransporter;
use App\Containers\AppSection\Salesforce\Models\SalesforceAnnualReview;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateSalesforceAnnualReviewTask extends Task
{
    public function __construct(protected SalesforceAnnualReviewRepository $repository)
    {
    }

    public function run(int $memberId, int $accountId, CreateSalesforceAnnualReviewTransporter $data, ?string $salesforceId = null): SalesforceAnnualReview
    {
        $data = array_merge([
            'member_id'     => $memberId,
            'account_id'    => $accountId,
            'salesforce_id' => $salesforceId,
        ], $data->toArray());

        try {
            return $this->repository->create($data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

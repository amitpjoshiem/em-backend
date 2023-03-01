<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\Account;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceAccountRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceAccount;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class SaveSalesforceAccountTask extends Task
{
    public function __construct(protected SalesforceAccountRepository $repository)
    {
    }

    public function run(int $memberId, ?string $salesforceId = null, array $data = []): SalesforceAccount
    {
        $data = array_merge([
            'salesforce_id' => $salesforceId,
        ], $data);

        try {
            return $this->repository->updateOrCreate([
                'member_id'             => $memberId,
            ], $data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

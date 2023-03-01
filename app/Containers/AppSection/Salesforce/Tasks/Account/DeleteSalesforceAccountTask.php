<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\Account;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceAccountRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceAccount;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteSalesforceAccountTask extends Task
{
    public function __construct(protected SalesforceAccountRepository $repository)
    {
    }

    /**
     * @throws DeleteResourceFailedException
     */
    public function run(SalesforceAccount $account, bool $withApi = true): bool
    {
        if ($withApi) {
            $account->api()->delete();
        }

        try {
            return (bool)$this->repository->delete($account->getKey());
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException(previous: $exception);
        }
    }
}

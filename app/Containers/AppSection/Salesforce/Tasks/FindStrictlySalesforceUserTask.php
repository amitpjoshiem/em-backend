<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceUserRepository;
use App\Containers\AppSection\Salesforce\Exceptions\SalesforceUserNotLoggedInException;
use App\Containers\AppSection\Salesforce\Models\SalesforceUser;
use App\Ship\Parents\Tasks\Task;

class FindStrictlySalesforceUserTask extends Task
{
    public function __construct(protected SalesforceUserRepository $repository)
    {
    }

    public function run(int $userId): string
    {
        /** @var SalesforceUser | null $salesforceUser */
        $salesforceUser = $this->repository->findByField('user_id', $userId)->first();

        if ($salesforceUser === null) {
            throw new SalesforceUserNotLoggedInException();
        }

        return $salesforceUser->salesforce_id;
    }
}

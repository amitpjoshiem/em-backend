<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceUserRepository;
use App\Containers\AppSection\Salesforce\Exceptions\SalesforceUserNotLoggedInException;
use App\Containers\AppSection\Salesforce\Models\SalesforceUser;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Tasks\Task;

class CheckSalesforceLoginTask extends Task
{
    public function __construct(protected SalesforceUserRepository $repository)
    {
    }

    /**
     * @throws SalesforceUserNotLoggedInException
     */
    public function run(): void
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();
        /** @var SalesforceUser | null $salesforceUser */
        $salesforceUser = $this->repository->findByField('user_id', $user->getKey())->first();

        if ($salesforceUser === null) {
            throw new SalesforceUserNotLoggedInException();
        }
    }
}

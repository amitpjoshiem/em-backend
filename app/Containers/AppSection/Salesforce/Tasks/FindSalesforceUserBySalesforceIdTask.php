<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceUserRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceUser;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Tasks\Task;

class FindSalesforceUserBySalesforceIdTask extends Task
{
    public function __construct(protected SalesforceUserRepository $repository)
    {
    }

    public function run(string $salesforceId): ?User
    {
        /** @var SalesforceUser | null $salesforceUser */
        $salesforceUser = $this->repository->findByField('salesforce_id', $salesforceId)->first();

        if ($salesforceUser !== null) {
            return app(FindUserByIdTask::class)->run($salesforceUser->user_id);
        }

        return null;
    }
}

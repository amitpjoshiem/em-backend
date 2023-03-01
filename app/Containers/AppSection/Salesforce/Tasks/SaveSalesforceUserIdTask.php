<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceUserRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceUser;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Tasks\Task;

class SaveSalesforceUserIdTask extends Task
{
    public function __construct(protected SalesforceUserRepository $repository)
    {
    }

    public function run(int $userId, string $salesforceId): SalesforceUser
    {
        try {
            return $this->repository->updateOrCreate([
                'user_id'       => $userId,
                'salesforce_id' => $salesforceId,
            ]);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

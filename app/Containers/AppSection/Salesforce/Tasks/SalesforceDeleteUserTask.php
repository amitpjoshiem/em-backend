<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceUserRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class SalesforceDeleteUserTask extends Task
{
    public function __construct(protected SalesforceUserRepository $repository)
    {
    }

    public function run(int $userId): bool
    {
        try {
            return (bool)$this->repository->deleteWhere([
                'user_id'   => $userId,
            ]);
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException(previous: $exception);
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteCompanyUsersTask extends Task
{
    public function __construct(protected UserRepository $repository)
    {
    }

    public function run(int $companyId): bool
    {
        try {
            return (bool)$this->repository->deleteWhere([
                'company_id' => $companyId,
            ]);
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException(previous: $exception);
        }
    }
}

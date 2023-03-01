<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\CompanyRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteCompanyTask extends Task
{
    public function __construct(protected CompanyRepository $repository)
    {
    }

    public function run(int $companyId): bool
    {
        try {
            return (bool)$this->repository->delete($companyId);
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException(previous: $exception);
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\CompanyRepository;
use App\Containers\AppSection\User\Models\Company;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindCompanyByIdTask extends Task
{
    public function __construct(protected CompanyRepository $repository)
    {
    }

    public function run(int $id): Company
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $exception) {
            throw new NotFoundException(previous: $exception);
        }
    }
}

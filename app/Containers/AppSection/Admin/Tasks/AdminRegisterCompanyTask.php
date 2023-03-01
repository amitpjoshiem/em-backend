<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Tasks;

use App\Containers\AppSection\User\Data\Repositories\CompanyRepository;
use App\Containers\AppSection\User\Models\Company;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Prettus\Validator\Exceptions\ValidatorException;

class AdminRegisterCompanyTask extends Task
{
    public function __construct(protected CompanyRepository $repository)
    {
    }

    /**
     * @throws ValidatorException|CreateResourceFailedException
     */
    public function run(array $data): Company
    {
        try {
            // Create new company
            return $this->repository->create($data);
        } catch (Exception $exception) {
            throw (new CreateResourceFailedException())->debug($exception);
        }
    }
}

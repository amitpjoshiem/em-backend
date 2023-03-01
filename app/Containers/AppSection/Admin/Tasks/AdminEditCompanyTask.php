<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Tasks;

use App\Containers\AppSection\User\Data\Repositories\CompanyRepository;
use App\Containers\AppSection\User\Models\Company;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Prettus\Validator\Exceptions\ValidatorException;

class AdminEditCompanyTask extends Task
{
    public function __construct(protected CompanyRepository $repository)
    {
    }

    /**
     * @throws ValidatorException|CreateResourceFailedException
     */
    public function run(array $data, int $id): Company
    {
        try {
            // Create new user
            return $this->repository->update($data, $id);
        } catch (Exception $exception) {
            throw (new CreateResourceFailedException())->debug($exception);
        }
    }
}

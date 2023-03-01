<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Ship\Criterias\Eloquent\NotNullCriteria;
use App\Ship\Parents\Tasks\Task;
use Prettus\Repository\Exceptions\RepositoryException;

class CountRegisteredUsersTask extends Task
{
    public function __construct(protected UserRepository $repository)
    {
    }

    public function run(): int
    {
        try {
            $this->repository->pushCriteria(new NotNullCriteria('email'));
        } catch (RepositoryException) {
            // idle
        }

        return $this->repository->all()->count();
    }
}

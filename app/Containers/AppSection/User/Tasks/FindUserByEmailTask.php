<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindUserByEmailTask extends Task
{
    public function __construct(protected UserRepository $repository)
    {
    }

    public function run(string $email): ?User
    {
        try {
            return $this->repository->findByField('email', $email)->first();
        } catch (Exception $exception) {
            throw new NotFoundException(previous: $exception);
        }
    }
}

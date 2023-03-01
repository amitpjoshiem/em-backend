<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Models\UserModel;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteUserTask extends Task
{
    public function __construct(protected UserRepository $repository)
    {
    }

    public function run(UserModel $user): bool
    {
        try {
            return (bool)$this->repository->withTrashed()->delete($user->id);
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException(previous: $exception);
        }
    }
}

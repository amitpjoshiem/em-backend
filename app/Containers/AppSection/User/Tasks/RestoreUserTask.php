<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Tasks\Task;

class RestoreUserTask extends Task
{
    public function __construct(protected UserRepository $repository)
    {
    }

    public function run(int $userId): ?bool
    {
        /** @var User $user */
        $user = $this->repository->withTrashed()->find($userId);

        return $user->restore();
    }
}

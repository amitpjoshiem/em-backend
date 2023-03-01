<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UsersTransferRepository;
use App\Containers\AppSection\User\Models\UsersTransfer;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateUsersTransferTask extends Task
{
    public function __construct(protected UsersTransferRepository $repository)
    {
    }

    public function run(int $fromId, int $toId): UsersTransfer
    {
        try {
            return $this->repository->create([
                'from_id'   => $fromId,
                'to_id'     => $toId,
            ]);
        } catch (Exception $exception) {
            throw (new CreateResourceFailedException(previous: $exception))->debug($exception);
        }
    }
}

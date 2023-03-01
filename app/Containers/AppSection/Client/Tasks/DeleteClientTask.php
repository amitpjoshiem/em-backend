<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Tasks;

use App\Containers\AppSection\Client\Data\Repositories\ClientRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteClientTask extends Task
{
    public function __construct(protected ClientRepository $repository)
    {
    }

    public function run(int $id): bool
    {
        try {
            return (bool)$this->repository->delete($id);
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException(previous: $exception);
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Tasks;

use App\Containers\AppSection\Client\Data\Repositories\ClientRepository;
use App\Containers\AppSection\Client\Models\Client;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Traits\TaskTraits\WithRelationsRepositoryTrait;
use Exception;

class FindClientByIdTask extends Task
{
    use WithRelationsRepositoryTrait;

    public function __construct(protected ClientRepository $repository)
    {
    }

    public function run(int $id): ?Client
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $exception) {
            throw new NotFoundException(previous: $exception);
        }
    }
}

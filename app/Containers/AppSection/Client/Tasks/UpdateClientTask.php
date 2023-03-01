<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Tasks;

use App\Containers\AppSection\Client\Data\Repositories\ClientRepository;
use App\Containers\AppSection\Client\Models\Client;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateClientTask extends Task
{
    public function __construct(protected ClientRepository $repository)
    {
    }

    public function run(int $clientId, array $data = []): Client
    {
        try {
            return $this->repository->update($data, $clientId);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

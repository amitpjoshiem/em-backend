<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Tasks;

use App\Containers\AppSection\Client\Data\Repositories\ClientRepository;
use App\Containers\AppSection\Client\Models\Client;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class SaveClientTask extends Task
{
    public function __construct(protected ClientRepository $repository)
    {
    }

    public function run(int $userId, int $memberId, array $data = []): Client
    {
        try {
            return $this->repository->updateOrCreate([
                'member_id' => $memberId,
                'user_id'   => $userId,
            ], $data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

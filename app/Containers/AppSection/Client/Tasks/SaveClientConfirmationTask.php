<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Tasks;

use App\Containers\AppSection\Client\Data\Repositories\ClientConfirmationRepository;
use App\Containers\AppSection\Client\Models\ClientConfirmation;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class SaveClientConfirmationTask extends Task
{
    public function __construct(protected ClientConfirmationRepository $repository)
    {
    }

    public function run(array $data): ClientConfirmation
    {
        try {
            return $this->repository->updateOrCreate([
                'member_id' => $data['member_id'],
                'client_id' => $data['client_id'],
                'group'     => $data['group'],
                'item'      => $data['item'],
            ], $data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

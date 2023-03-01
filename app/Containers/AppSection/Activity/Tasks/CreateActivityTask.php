<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\Tasks;

use App\Containers\AppSection\Activity\Data\Repositories\UserActivityRepository;
use App\Containers\AppSection\Activity\Models\UserActivity;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateActivityTask extends Task
{
    public function __construct(protected UserActivityRepository $repository)
    {
    }

    public function run(array $data): UserActivity
    {
        try {
            return $this->repository->create($data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

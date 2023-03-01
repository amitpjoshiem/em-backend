<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberEmploymentHistoryRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteEmploymentHistoryByIdTask extends Task
{
    public function __construct(protected MemberEmploymentHistoryRepository $repository)
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

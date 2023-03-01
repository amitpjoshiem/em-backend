<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberEmploymentHistoryRepository;
use App\Containers\AppSection\Member\Models\MemberEmploymentHistory;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindEmploymentHistoryByIdTask extends Task
{
    public function __construct(protected MemberEmploymentHistoryRepository $repository)
    {
    }

    public function run(int $id): MemberEmploymentHistory
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException(previous: $exception);
        }
    }
}

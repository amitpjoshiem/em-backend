<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Tasks;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Repositories\FixedIndexAnnuitiesRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteFixedIndexAnnuitiesTask extends Task
{
    public function __construct(protected FixedIndexAnnuitiesRepository $repository)
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

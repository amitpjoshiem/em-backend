<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Tasks;

use App\Containers\AppSection\ClientReport\Data\Repositories\ClientReportRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteClientReportTask extends Task
{
    public function __construct(protected ClientReportRepository $repository)
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

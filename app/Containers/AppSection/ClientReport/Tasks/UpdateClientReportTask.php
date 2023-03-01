<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Tasks;

use App\Containers\AppSection\ClientReport\Data\Repositories\ClientReportRepository;
use App\Containers\AppSection\ClientReport\Models\ClientReport;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateClientReportTask extends Task
{
    public function __construct(protected ClientReportRepository $repository)
    {
    }

    public function run(int $id, array $data): ClientReport
    {
        try {
            return $this->repository->update($data, $id);
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }
}

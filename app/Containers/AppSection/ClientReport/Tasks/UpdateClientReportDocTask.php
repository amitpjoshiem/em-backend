<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Tasks;

use App\Containers\AppSection\ClientReport\Data\Repositories\ClientReportsDocRepository;
use App\Containers\AppSection\ClientReport\Models\ClientReportsDoc;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateClientReportDocTask extends Task
{
    public function __construct(protected ClientReportsDocRepository $repository)
    {
    }

    public function run(int $id, array $data): ClientReportsDoc
    {
        try {
            return $this->repository->update($data, $id);
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }
}

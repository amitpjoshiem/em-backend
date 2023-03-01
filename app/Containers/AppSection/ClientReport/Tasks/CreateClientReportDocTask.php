<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Tasks;

use App\Containers\AppSection\ClientReport\Data\Repositories\ClientReportsDocRepository;
use App\Containers\AppSection\ClientReport\Models\ClientReportsDoc;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Tasks\Task;

class CreateClientReportDocTask extends Task
{
    public function __construct(protected ClientReportsDocRepository $repository)
    {
    }

    public function run(array $data): ClientReportsDoc
    {
        try {
            return $this->repository->create($data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

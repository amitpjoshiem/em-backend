<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Tasks;

use App\Containers\AppSection\ClientReport\Data\Repositories\ClientReportsDocRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Tasks\Task;

class SaveClientReportDocContractsTask extends Task
{
    public function __construct(protected ClientReportsDocRepository $repository)
    {
    }

    public function run(int $docId, array $contracts): array
    {
        try {
            return $this->repository->sync($docId, 'contracts', $contracts);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

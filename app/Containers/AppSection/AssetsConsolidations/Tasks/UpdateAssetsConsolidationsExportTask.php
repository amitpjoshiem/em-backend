<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Tasks;

use App\Containers\AppSection\AssetsConsolidations\Data\Repositories\AssetsConsolidationsExportRepository;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsExport;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateAssetsConsolidationsExportTask extends Task
{
    public function __construct(protected AssetsConsolidationsExportRepository $repository)
    {
    }

    public function run(int $id, array $data): AssetsConsolidationsExport
    {
        try {
            return $this->repository->update($data, $id);
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }
}

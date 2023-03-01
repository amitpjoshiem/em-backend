<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Tasks;

use App\Containers\AppSection\AssetsConsolidations\Data\Repositories\AssetsConsolidationsExportRepository;
use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\CreateExportExcelAssetsConsolidationsTransporter;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsExport;
use App\Ship\Core\Abstracts\Exceptions\Exception;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;

class CreateAssetsConsolidationsExportTask extends Task
{
    public function __construct(protected AssetsConsolidationsExportRepository $repository)
    {
    }

    public function run(CreateExportExcelAssetsConsolidationsTransporter $input): AssetsConsolidationsExport
    {
        try {
            return $this->repository->create($input->toArray());
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

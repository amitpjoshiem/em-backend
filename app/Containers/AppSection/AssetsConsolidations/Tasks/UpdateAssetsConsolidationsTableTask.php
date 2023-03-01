<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Tasks;

use App\Containers\AppSection\AssetsConsolidations\Data\Repositories\AssetsConsolidationsTableRepository;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsTable;
use App\Ship\Core\Abstracts\Exceptions\Exception;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;

class UpdateAssetsConsolidationsTableTask extends Task
{
    public function __construct(protected AssetsConsolidationsTableRepository $repository)
    {
    }

    public function run(int $table_id, array $data): AssetsConsolidationsTable
    {
        try {
            return $this->repository->update($data, $table_id);
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }
}

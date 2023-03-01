<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Tasks;

use App\Containers\AppSection\AssetsConsolidations\Data\Repositories\AssetsConsolidationsRepository;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidations;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateAssetsConsolidationsTask extends Task
{
    public function __construct(protected AssetsConsolidationsRepository $repository)
    {
    }

    public function run(int $id, array $data): AssetsConsolidations
    {
        try {
            return $this->repository->update($data, $id);
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }
}

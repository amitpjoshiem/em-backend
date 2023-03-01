<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Tasks;

use App\Containers\AppSection\AssetsConsolidations\Data\Repositories\AssetsConsolidationsRepository;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidations;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindAssetsConsolidationsByIdTask extends Task
{
    public function __construct(protected AssetsConsolidationsRepository $repository)
    {
    }

    public function run(int $id): ?AssetsConsolidations
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $exception) {
            throw new NotFoundException(previous: $exception);
        }
    }
}

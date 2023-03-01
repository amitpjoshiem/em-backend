<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Tasks;

use App\Containers\AppSection\AssetsConsolidations\Data\Repositories\AssetsConsolidationsTableRepository;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsTable;
use App\Ship\Core\Abstracts\Exceptions\Exception;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;

class CreateAssetsConsolidationsTableTask extends Task
{
    public function __construct(protected AssetsConsolidationsTableRepository $repository)
    {
    }

    public function run(string $name, int $member_id): AssetsConsolidationsTable
    {
        try {
            return $this->repository->create([
                'member_id' => $member_id,
                'name'      => $name,
            ]);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

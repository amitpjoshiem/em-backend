<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Tasks;

use App\Containers\AppSection\AssetsConsolidations\Data\Repositories\AssetsConsolidationsRepository;
use App\Ship\Parents\Tasks\Task;

class GetAssetsConsolidationsTableCountTask extends Task
{
    public function __construct(protected AssetsConsolidationsRepository $repository)
    {
    }

    public function run(int $member_id, int $table): int
    {
        return $this->repository->findWhere([
            'member_id'    => $member_id,
            'table_id'     => $table,
        ])->count();
    }
}

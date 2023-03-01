<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Tasks;

use App\Containers\AppSection\AssetsConsolidations\Data\Repositories\AssetsConsolidationsTableRepository;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsTable;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Parents\Tasks\Task;

class GetAssetsConsolidationsTableTask extends Task
{
    public function __construct(protected AssetsConsolidationsTableRepository $repository)
    {
    }

    public function run(int $table_id): AssetsConsolidationsTable
    {
        return $this->repository->find($table_id);
    }

    public function withMember(): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria('member'));

        return $this;
    }

    public function withRows(): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria('rows'));

        return $this;
    }
}

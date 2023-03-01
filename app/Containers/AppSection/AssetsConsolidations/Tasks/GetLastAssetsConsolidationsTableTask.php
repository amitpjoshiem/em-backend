<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Tasks;

use App\Containers\AppSection\AssetsConsolidations\Data\Repositories\AssetsConsolidationsRepository;
use App\Ship\Parents\Tasks\Task;

class GetLastAssetsConsolidationsTableTask extends Task
{
    public function __construct(protected AssetsConsolidationsRepository $repository)
    {
    }

    public function run(int $member_id): int
    {
        /** @var int | null $lastTable */
        $lastTable = $this->repository->findWhere(['member_id' => $member_id])->max('table');

        return (int)$lastTable + 1;
    }
}

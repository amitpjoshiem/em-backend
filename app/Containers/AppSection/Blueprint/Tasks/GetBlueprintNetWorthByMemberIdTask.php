<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Tasks;

use App\Containers\AppSection\Blueprint\Data\Repositories\BlueprintNetworthRepository;
use App\Containers\AppSection\Blueprint\Models\BlueprintNetworth;
use App\Ship\Parents\Tasks\Task;

class GetBlueprintNetWorthByMemberIdTask extends Task
{
    public function __construct(protected BlueprintNetworthRepository $repository)
    {
    }

    public function run(int $member_id): ?BlueprintNetworth
    {
        return $this->repository->findByField('member_id', $member_id)->first();
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Tasks;

use App\Containers\AppSection\Blueprint\Data\Repositories\BlueprintConcernRepository;
use App\Containers\AppSection\Blueprint\Models\BlueprintConcern;
use App\Ship\Parents\Tasks\Task;

class GetBlueprintConcernByMemberIdTask extends Task
{
    public function __construct(protected BlueprintConcernRepository $repository)
    {
    }

    public function run(int $member_id): ?BlueprintConcern
    {
        return $this->repository->findByField('member_id', $member_id)->first();
    }
}

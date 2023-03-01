<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Tasks;

use App\Containers\AppSection\Blueprint\Data\Repositories\BlueprintDocRepository;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;

class FindAllBlueprintDocByMemberIdTask extends Task
{
    public function __construct(protected BlueprintDocRepository $repository)
    {
    }

    public function run(int $memberId): Collection
    {
        return $this->repository->findByField('member_id', $memberId);
    }

    public function withMedia(): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria('doc'));

        return $this;
    }
}

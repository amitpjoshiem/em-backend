<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Tasks;

use App\Containers\AppSection\ClientReport\Data\Repositories\ClientReportsDocRepository;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;

class GetAllClientReportsDocsByMemberIdTask extends Task
{
    public function __construct(protected ClientReportsDocRepository $repository)
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

    public function withMember(): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria(['member', 'contracts.member']));

        return $this;
    }

    public function withContracts(): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria('contracts'));

        return $this;
    }
}

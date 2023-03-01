<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Tasks;

use App\Containers\AppSection\Client\Data\Repositories\ClientConfirmationRepository;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;

class GetClientConfirmationTask extends Task
{
    public function __construct(protected ClientConfirmationRepository $repository)
    {
    }

    public function run(): Collection
    {
        return $this->repository->all();
    }

    public function filterByMemberId(int $memberId): self
    {
        $this->repository->pushCriteria(new ThisEqualThatCriteria('member_id', $memberId));

        return $this;
    }

    public function filterByClientId(int $clientId): self
    {
        $this->repository->pushCriteria(new ThisEqualThatCriteria('client_id', $clientId));

        return $this;
    }
}

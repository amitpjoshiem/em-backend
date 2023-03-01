<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Tasks;

use App\Containers\AppSection\Client\Data\Repositories\ClientRepository;
use App\Containers\AppSection\Client\Models\Client;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Parents\Tasks\Task;

class FindClientByUserIdTask extends Task
{
    public function __construct(protected ClientRepository $repository)
    {
    }

    public function run(int $userId): ?Client
    {
        return $this->repository->findByField('user_id', $userId)->first();
    }

    public function withRelations(array $relations): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria($relations));

        return $this;
    }
}

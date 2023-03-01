<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindUserByIdTask extends Task
{
    public function __construct(protected UserRepository $repository)
    {
    }

    public function run(int $userId): ?User
    {
        try {
            return $this->repository->withTrashed()->find($userId);
        } catch (Exception $exception) {
            throw new NotFoundException(previous: $exception);
        }
    }

    public function withRelations(array $relations): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria($relations));

        return $this;
    }
}

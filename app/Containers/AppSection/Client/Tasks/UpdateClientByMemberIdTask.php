<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Tasks;

use App\Containers\AppSection\Client\Data\Repositories\ClientRepository;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class UpdateClientByMemberIdTask extends Task
{
    public function __construct(protected ClientRepository $repository)
    {
    }

    public function run(int $memberId, array $data = []): Collection|bool
    {
        try {
            $this->repository->pushCriteria(new ThisEqualThatCriteria('member_id', $memberId));

            return $this->repository->updateByCriteria($data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

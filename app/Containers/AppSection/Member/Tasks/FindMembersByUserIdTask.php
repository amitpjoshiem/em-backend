<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberRepository;
use App\Containers\AppSection\User\Traits\TaskTraits\FilterByUserRepositoryTrait;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class FindMembersByUserIdTask extends Task
{
    use FilterByUserRepositoryTrait;

    public function __construct(protected MemberRepository $repository)
    {
    }

    /**
     * @throws NotFoundException
     */
    public function run(int $userId): Collection
    {
        try {
            return $this->repository->findWhere(['user_id' => $userId]);
        } catch (Exception $exception) {
            throw new NotFoundException(previous: $exception);
        }
    }
}

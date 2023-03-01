<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks\Contacts;

use App\Containers\AppSection\Member\Data\Repositories\MemberContactRepository;
use App\Containers\AppSection\User\Traits\TaskTraits\FilterByUserRepositoryTrait;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Parents\Tasks\Task;
use Prettus\Repository\Exceptions\RepositoryException;

class RemoveSpouseMarkContactTask extends Task
{
    use FilterByUserRepositoryTrait;

    public function __construct(protected MemberContactRepository $repository)
    {
    }

    public function run(int $memberId): bool
    {
        try {
            $this->repository->pushCriteria(new ThisEqualThatCriteria('member_id', $memberId));

            $this->repository->updateByCriteria(['is_spouse' => false]);
        } catch (RepositoryException) {
            return false;
        }

        return true;
    }
}

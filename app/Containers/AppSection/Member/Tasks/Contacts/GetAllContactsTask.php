<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks\Contacts;

use App\Containers\AppSection\Member\Data\Repositories\MemberContactRepository;
use App\Containers\AppSection\User\Traits\TaskTraits\FilterByUserRepositoryTrait;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetAllContactsTask extends Task
{
    use FilterByUserRepositoryTrait;

    public function __construct(protected MemberContactRepository $repository)
    {
    }

    public function run(bool $skipPagination = false): Collection | LengthAwarePaginator
    {
        return $skipPagination ? $this->repository->all() : $this->repository->paginate();
    }

    public function filterByMemberId(int $memberId): self
    {
        $this->repository->pushCriteria(new ThisEqualThatCriteria('member_id', $memberId));

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberRepository;
use App\Containers\AppSection\User\Traits\TaskTraits\FilterByUserRepositoryTrait;
use App\Ship\Parents\Tasks\Task;
use Carbon\Carbon;

class GetCountMembersTask extends Task
{
    use FilterByUserRepositoryTrait;

    public function __construct(protected MemberRepository $repository)
    {
    }

    public function run(): int
    {
        return $this->repository->count();
    }

    public function filterByType(string $type): self
    {
        $this->repository->findWhere(['type' => $type]);

        return $this;
    }

    public function filterFromDate(Carbon $date): self
    {
        $this->repository->findWhere([['created_at', '>=', $date->format('Y-m-d')]]);

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberRepository;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\User\Traits\TaskTraits\FilterByUserRepositoryTrait;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Traits\TaskTraits\WithRelationsRepositoryTrait;
use Exception;

class FindMemberByIdTask extends Task
{
    use FilterByUserRepositoryTrait;
    use WithRelationsRepositoryTrait;

    public function __construct(protected MemberRepository $repository)
    {
    }

    /**
     * @throws NotFoundException
     */
    public function run(int $id): Member
    {
        try {
            $member = $this->repository->find($id);
        } catch (Exception $exception) {
            throw new NotFoundException(previous: $exception);
        }

        if ($member === null) {
            throw new NotFoundException();
        }

        return $member;
    }

    public function withTrashed(bool $isAdmin): self
    {
        if ($isAdmin) {
            $this->repository->withTrashed();
        }

        return $this;
    }
}

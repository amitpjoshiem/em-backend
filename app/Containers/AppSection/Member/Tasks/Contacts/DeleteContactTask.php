<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks\Contacts;

use App\Containers\AppSection\Member\Data\Repositories\MemberContactRepository;
use App\Containers\AppSection\User\Traits\TaskTraits\FilterByUserRepositoryTrait;
use App\Ship\Parents\Tasks\Task;

class DeleteContactTask extends Task
{
    use FilterByUserRepositoryTrait;

    public function __construct(protected MemberContactRepository $repository)
    {
    }

    public function run(int $id): bool
    {
        return (bool)$this->repository->delete($id);
    }
}

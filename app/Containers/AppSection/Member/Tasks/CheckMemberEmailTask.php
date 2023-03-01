<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberRepository;
use App\Ship\Parents\Tasks\Task;

class CheckMemberEmailTask extends Task
{
    public function __construct(protected MemberRepository $repository)
    {
    }

    public function run(string $email): bool
    {
        $member = $this->repository->findByField('email', $email)->first();

        return $member !== null;
    }
}

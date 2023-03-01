<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberRepository;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateMemberTask extends Task
{
    public function __construct(protected MemberRepository $repository)
    {
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run(array $data): Member
    {
        try {
            return $this->repository->create($data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(message: '123', previous: $exception);
        }
    }
}

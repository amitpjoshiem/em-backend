<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberRepository;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Prettus\Validator\Exceptions\ValidatorException;

class ConvertMemberTask extends Task
{
    public function __construct(protected MemberRepository $repository)
    {
    }

    /**
     * @throws ValidatorException
     */
    public function run(int $memberId): Member
    {
        try {
            return $this->repository->update(['type' => 'client'], $memberId);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

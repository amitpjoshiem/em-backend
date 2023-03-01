<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberRepository;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Core\Abstracts\Exceptions\Exception;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class ConvertLeadTask extends Task
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
            return $this->repository->update(['type' => Member::PROSPECT], $memberId);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

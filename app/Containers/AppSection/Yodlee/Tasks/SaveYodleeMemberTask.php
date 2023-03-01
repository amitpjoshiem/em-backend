<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Tasks;

use App\Containers\AppSection\Yodlee\Data\Repositories\YodleeMemberRepository;
use App\Containers\AppSection\Yodlee\Exceptions\BaseException;
use App\Containers\AppSection\Yodlee\Models\YodleeMember;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Tasks\Task;

class SaveYodleeMemberTask extends Task
{
    public function __construct(protected YodleeMemberRepository $repository)
    {
    }

    /**
     * @throws BaseException
     */
    public function run(array $data, int $memberId): YodleeMember
    {
        try {
            return $this->repository->updateOrCreate([
                'member_id' => $memberId,
            ], $data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Tasks;

use App\Containers\AppSection\Yodlee\Data\Repositories\YodleeMemberRepository;
use App\Containers\AppSection\Yodlee\Exceptions\BaseException;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class GetAllYodleeMembersTask extends Task
{
    public function __construct(protected YodleeMemberRepository $repository)
    {
    }

    /**
     * @throws BaseException
     */
    public function run(): Collection
    {
        return $this->repository->all();
    }
}

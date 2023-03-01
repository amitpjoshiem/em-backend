<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Tasks;

use App\Containers\AppSection\Yodlee\Data\Repositories\YodleeAccountsRepository;
use App\Containers\AppSection\Yodlee\Exceptions\BaseException;
use App\Ship\Criterias\Eloquent\SumCriteria;
use App\Ship\Criterias\Eloquent\ThisBetweenDatesCriteria;
use App\Ship\Parents\Tasks\Task;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class GetYodleeAccountsByMemberIdsTask extends Task
{
    public function __construct(protected YodleeAccountsRepository $repository)
    {
    }

    /**
     * @throws BaseException
     */
    public function run(array $memberIds): Collection
    {
        return $this->repository->findWhereIn('member_id', $memberIds);
    }

    public function filterFromDate(Carbon $date): self
    {
        $this->repository->pushCriteria(new ThisBetweenDatesCriteria('created_at', $date, Carbon::now()->addDay()));

        return $this;
    }

    public function sum(): self
    {
        $this->repository->pushCriteria(new SumCriteria('balance'));

        return $this;
    }
}

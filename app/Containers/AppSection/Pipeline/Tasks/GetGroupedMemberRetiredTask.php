<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberRepository;
use App\Containers\AppSection\User\Traits\TaskTraits\FilterByCompanyTrait;
use App\Containers\AppSection\User\Traits\TaskTraits\FilterByUserRepositoryTrait;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class GetGroupedMemberRetiredTask extends Task
{
    use FilterByCompanyTrait;
    use FilterByUserRepositoryTrait;

    public function __construct(protected MemberRepository $repository)
    {
    }

    public function run(): Collection
    {
        $retiredRaw   = 'count(CASE WHEN retired THEN 1 END)';
        $employersRaw = 'count(CASE WHEN NOT(retired) THEN 1 END)';
        $monthRaw     = "DATE_FORMAT(created_at, '%Y-%m')";

        return $this->repository->getBuilder()
            ->selectRaw(sprintf('%s as month, %s as employers, %s as retired', $monthRaw, $employersRaw, $retiredRaw))
            ->groupBy('month')
            ->get();
    }
}

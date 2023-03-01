<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberRepository;
use App\Containers\AppSection\User\Traits\TaskTraits\FilterByCompanyTrait;
use App\Containers\AppSection\User\Traits\TaskTraits\FilterByUserRepositoryTrait;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class GetGroupedMemberCountTask extends Task
{
    use FilterByCompanyTrait;
    use FilterByUserRepositoryTrait;

    public function __construct(protected MemberRepository $repository)
    {
    }

    public function run(): Collection
    {
        $dateRaw = "DATE_FORMAT(created_at, '%Y-%m')";

        return $this->repository
            ->getBuilder()
            ->selectRaw(sprintf('%s as month, count(id) as count', $dateRaw))
            ->groupByRaw($dateRaw)->get();
    }
}

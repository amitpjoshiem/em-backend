<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberRepository;
use App\Containers\AppSection\User\Traits\TaskTraits\FilterByCompanyTrait;
use App\Containers\AppSection\User\Traits\TaskTraits\FilterByUserRepositoryTrait;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class GetGroupedPipelineMemberAgeTask extends Task
{
    use FilterByCompanyTrait;
    use FilterByUserRepositoryTrait;

    public function __construct(protected MemberRepository $repository)
    {
    }

    public function run(): Collection
    {
        $ageRaw = 'TRUNCATE((DATEDIFF(CURRENT_DATE, birthday) / 365.25), 0)';

        return $this->repository->getBuilder()
            ->selectRaw(sprintf('%s as age, count(id) as sum', $ageRaw))
            ->groupBy('age')->get();
    }
}

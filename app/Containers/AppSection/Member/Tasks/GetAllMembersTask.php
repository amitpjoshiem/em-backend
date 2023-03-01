<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Criterias\FilterByOwnerCriteria;
use App\Containers\AppSection\Member\Data\Repositories\MemberRepository;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\User\Traits\TaskTraits\FilterByCompanyTrait;
use App\Containers\AppSection\User\Traits\TaskTraits\FilterByUserRepositoryTrait;
use App\Ship\Criterias\Eloquent\ThisBetweenDatesCriteria;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Traits\EagerLoadPivotBuilder;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;

class GetAllMembersTask extends Task
{
    use FilterByCompanyTrait;
    use FilterByUserRepositoryTrait;

    private ?string $status;

    public function __construct(protected MemberRepository $repository)
    {
    }

    public function run(bool $skipPagination = false): Collection | LengthAwarePaginator
    {
        $repository = $this->repository;

        if (isset($this->status)) {
            $repository = $this->applyStatusFilter();
        }

        return $skipPagination ? $repository->all() : $repository->paginate();
    }

    public function withTrashed(bool $isAdmin): self
    {
        if ($isAdmin) {
            $this->repository->withTrashed();
        }

        return $this;
    }

    public function filterByType(string $type): self
    {
        $this->repository->pushCriteria(new ThisEqualThatCriteria('type', $type));

        return $this;
    }

    public function filterFromDate(Carbon $date): self
    {
        $this->repository->pushCriteria(new ThisBetweenDatesCriteria('created_at', $date, Carbon::now()->addDay()));

        return $this;
    }

    public function count(): int
    {
        return $this->repository->count();
    }

    public function withRelations(array $relations): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria($relations));

        return $this;
    }

    public function filterByStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    private function applyStatusFilter(): BaseRepository
    {
        return $this->repository->whereHas('client.user', function (EagerLoadPivotBuilder $query): void {
            if ($this->status === Member::ACTIVE_STATUS) {
                $query->where('deleted_at', value: null);
            } elseif ($this->status === Member::INACTIVE_STATUS) {
                $query->where('deleted_at', '!=', null);
            }
        });
    }

    public function filterByOwner(): self
    {
        $this->repository->pushCriteria(new FilterByOwnerCriteria());

        return $this;
    }
}

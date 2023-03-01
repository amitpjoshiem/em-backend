<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Criterias\RoleCriteria;
use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Ship\Criterias\Eloquent\OrderByCreationDateDescendingCriteria;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Criterias\Eloquent\ThisLikeByTwoFieldsCriteria;
use App\Ship\Criterias\Eloquent\ThisMatchListThat;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllUsersTask extends Task
{
    public function __construct(protected UserRepository $repository)
    {
    }

    public function run(bool $skipPagination = true): Collection | LengthAwarePaginator
    {
        return $skipPagination ? $this->repository->all() : $this->repository->paginate();
    }

    /**
     * @throws RepositoryException
     */
    public function ordered(): self
    {
        $this->repository->pushCriteria(new OrderByCreationDateDescendingCriteria());

        return $this;
    }

    /**
     * @throws RepositoryException
     */
    public function withRole(string $roles): self
    {
        $this->repository->pushCriteria(new RoleCriteria($roles));

        return $this;
    }

    /**
     * @throws RepositoryException
     */
    public function withRoles(): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria('roles'));

        return $this;
    }

    /**
     * @throws RepositoryException
     */
    public function withCompany(): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria('company'));

        return $this;
    }

    public function withMedia(): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria('media'));

        return $this;
    }

    public function withRelations(array $relations): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria($relations));

        return $this;
    }

    public function filterByCompany(int $companyId): self
    {
        $this->repository->pushCriteria(new ThisEqualThatCriteria('company_id', $companyId));

        return $this;
    }

    public function filterByIds(array $ids): self
    {
        $this->repository->pushCriteria(new ThisMatchListThat('id', $ids));

        return $this;
    }

    public function filterByRequestName(): self
    {
        /** @var Request $request */
        $request = app(Request::class);

        if (!$request->has('name_search')) {
            return $this;
        }

        $name = $request->get('name_search');

        $this->repository->pushCriteria(new ThisLikeByTwoFieldsCriteria(['first_name', 'last_name'], $name));

        return $this;
    }
}

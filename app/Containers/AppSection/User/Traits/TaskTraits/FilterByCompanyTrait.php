<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Traits\TaskTraits;

use App\Ship\Criterias\Eloquent\FilterByRelationCriteria;
use App\Ship\Parents\Repositories\Repository;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Trait FilterByComapnyTrait.
 *
 * @property Repository $repository
 */
trait FilterByCompanyTrait
{
    /**
     * @throws RepositoryException
     */
    public function filterByCompany(int $companyId, string $relation = 'user'): static
    {
        $this->repository->pushCriteria(new FilterByRelationCriteria($relation, 'company_id', value: $companyId));

        return $this;
    }
}

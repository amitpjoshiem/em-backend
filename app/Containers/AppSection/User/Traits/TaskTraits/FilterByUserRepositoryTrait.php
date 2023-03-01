<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Traits\TaskTraits;

use App\Ship\Criterias\Eloquent\ThisUserCriteria;
use App\Ship\Parents\Repositories\Repository;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Trait FilterByUserRepositoryTrait.
 *
 * @property Repository $repository
 */
trait FilterByUserRepositoryTrait
{
    /**
     * @throws RepositoryException
     */
    public function filterByUser(?int $userId = null): static
    {
        $this->repository->pushCriteria(new ThisUserCriteria($userId));

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Traits\TaskTraits;

use App\Ship\Criterias\Eloquent\ThisUserCriteria;
use App\Ship\Parents\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait ScopeFilterByUserRepositoryTrait.
 *
 * @property Repository $repository
 */
trait ScopeFilterByUserRepositoryTrait
{
    public function filterByUser(?int $userId = null): static
    {
        $this->repository->scopeQuery(
            /** @param Model|Builder $model */
            fn (Model | Builder $model): Builder => (new ThisUserCriteria($userId))->apply($model, $this->repository)
        );

        return $this;
    }
}

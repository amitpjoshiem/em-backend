<?php

declare(strict_types=1);

namespace App\Ship\Parents\Traits\TaskTraits;

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
    public function filterByUser(?int $userId = null): Repository
    {
        return $this->repository->scopeQuery(
            /** @psalm-param Model|Builder $model */
            fn ($model): Builder => (new ThisUserCriteria($userId))->apply($model, $this->repository)
        );
    }
}

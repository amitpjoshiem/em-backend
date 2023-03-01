<?php

declare(strict_types=1);

namespace App\Ship\Parents\Traits\TaskTraits;

use App\Ship\Core\Abstracts\Tasks\Task;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Parents\Repositories\Repository;

/**
 * Trait ScopeFilterByUserRepositoryTrait.
 *
 * @property Repository $repository
 */
trait WithRelationsRepositoryTrait
{
    public function withRelations(array $relations): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria($relations));

        return $this;
    }
}

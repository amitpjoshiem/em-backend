<?php

declare(strict_types=1);

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WithRelationsCriteria extends Criteria
{
    public function __construct(private string | array $relations)
    {
    }

    /**
     * @psalm-param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->with($this->relations);
    }
}

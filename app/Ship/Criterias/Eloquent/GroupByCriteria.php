<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class GroupByCriteria extends Criteria
{
    public function __construct(private string $field)
    {
    }

    /**
     * @psalm-param EloquentBuilder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->groupBy($this->field);
    }
}

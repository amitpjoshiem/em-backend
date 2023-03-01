<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class CreatedTodayCriteria extends Criteria
{
    /**
     * @psalm-param EloquentBuilder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->where('created_at', '>=', today()->toDateString());
    }
}

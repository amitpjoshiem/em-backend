<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class OrderByUpdateDateDescendingCriteria extends Criteria
{
    /**
     * @psalm-param EloquentBuilder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): EloquentBuilder
    {
        return $model->orderBy('updated_at', 'desc');
    }
}

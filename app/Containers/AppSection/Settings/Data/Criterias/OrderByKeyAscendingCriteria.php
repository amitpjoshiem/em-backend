<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Settings\Data\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class OrderByKeyAscendingCriteria extends Criteria
{
    /**
     * @psalm-param EloquentBuilder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): EloquentBuilder
    {
        return $model->orderBy('key', 'asc');
    }
}

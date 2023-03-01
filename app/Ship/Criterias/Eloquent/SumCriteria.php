<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class SumCriteria extends Criteria
{
    public function __construct(private string $field)
    {
    }

    /**
     * @psalm-param EloquentBuilder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return DB::table($model->getModel()->getTable())->select(DB::raw('sum(' . $this->field . ') as sum'));
    }
}

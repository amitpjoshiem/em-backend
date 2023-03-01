<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class CountCriteria extends Criteria
{
    public function __construct(private string $field)
    {
    }

    /**
     * @psalm-param EloquentBuilder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return DB::table($model->getModel()->getTable())->select($this->field, DB::raw('count(' . $this->field . ') as total_count'))->groupBy($this->field);
    }
}

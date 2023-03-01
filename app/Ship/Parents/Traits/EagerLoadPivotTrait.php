<?php

namespace App\Ship\Parents\Traits;

use Illuminate\Database\Query\Builder as QueryBuilder;

trait EagerLoadPivotTrait
{
    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param QueryBuilder $query
     */
    public function newEloquentBuilder($query): EagerLoadPivotBuilder
    {
        return new EagerLoadPivotBuilder($query);
    }
}

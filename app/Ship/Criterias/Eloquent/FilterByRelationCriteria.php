<?php

declare(strict_types=1);

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class FilterByRelationCriteria extends Criteria
{
    public function __construct(private string $relation, private string $field, private string $operator = '=', private mixed $value = null)
    {
    }

    /**
     * @psalm-param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->whereHas($this->relation, function (EloquentBuilder $q) {
            $q->where($this->field, $this->operator, $this->value);
        });
    }
}

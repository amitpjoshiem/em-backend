<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class SelectDistinctTableCriteria extends Criteria
{
    public function __construct(private ?array $fields = null)
    {
    }

    /**
     * @psalm-param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        $table = $model->getModel()->getTable();

        $fields = empty($this->fields) ? "{$table}.*" : array_map(fn ($field) => "{$table}.{$field}", $this->fields);

        return $model->select($fields)->distinct();
    }
}

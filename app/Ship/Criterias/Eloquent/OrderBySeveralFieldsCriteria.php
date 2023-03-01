<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class OrderBySeveralFieldsCriteria extends Criteria
{
    public function __construct(private string $field, private array $values)
    {
    }

    /**
     * @psalm-param Model $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        $placeholders = implode(', ', array_fill(0, count($this->values), '?'));

        return $model->orderByRaw("FIELD({$this->field}, {$placeholders})", $placeholders);
    }
}

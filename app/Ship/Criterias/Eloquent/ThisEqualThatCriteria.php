<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class ThisEqualThatCriteria extends Criteria
{
    public function __construct(private string $field, private mixed $value)
    {
    }

    /**
     * @psalm-param Model $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->where($this->field, $this->value);
    }
}

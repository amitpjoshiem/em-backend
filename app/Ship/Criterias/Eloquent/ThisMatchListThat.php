<?php

declare(strict_types=1);

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;

class ThisMatchListThat extends Criteria
{
    public function __construct(private string $field, private array $values)
    {
    }

    /**
     * @psalm-param Builder $model
     */
    public function apply($model, RepositoryInterface $repository): Builder
    {
        return $model->whereIn($this->field, $this->values);
    }
}

<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use App\Ship\Parents\Models\Model;
use App\Ship\Parents\Traits\EagerLoadPivotBuilder;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class ThisBetweenDatesCriteria.
 *
 * Retrieves all entities whose date $field's value is between $start and $end.
 */
class ThisLessThanDateCriteria extends Criteria
{
    public function __construct(private string $field, private Carbon $date)
    {
    }

    /**
     * @psalm-param Model $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): EagerLoadPivotBuilder | Builder
    {
        return $model->where($this->field, '<', $this->date->toDateString());
    }
}

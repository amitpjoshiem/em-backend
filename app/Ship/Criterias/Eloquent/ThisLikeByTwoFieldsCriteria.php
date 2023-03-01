<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use App\Ship\Parents\Traits\EagerLoadPivotBuilder;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class ThisLikeThatCriteria.
 *
 * Retrieves all entities where $field contains one or more of the given items in $valueString.
 */
class ThisLikeByTwoFieldsCriteria extends Criteria
{
    public function __construct(
        private array $fields,
        private string $valueString,
    ) {
    }

    /**
     * Applies the criteria - if more than one value is separated by the configured separator we will "OR" all the params.
     *
     * @psalm-param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): EagerLoadPivotBuilder | Builder
    {
        return $model->where(function (EagerLoadPivotBuilder | Builder $query) {
            $likeValue = sprintf("%%%s%%", $this->valueString);
            foreach ($this->fields as $key => $field) {
                if ($key === 0) {
                    $query->where($field, 'LIKE', $likeValue);
                    continue;
                }
                $query->orWhere($field, 'LIKE', $likeValue);
            }
        });
    }
}

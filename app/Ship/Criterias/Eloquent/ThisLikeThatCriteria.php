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
class ThisLikeThatCriteria extends Criteria
{
    public function __construct(
        /** Name of the column */
        private string $field,
        /** Contains values separated by */
        private string $valueString,
        /** Separates separate items in the given string. Default is csv. */
        private string $separator = ',',
        /** This character is replaced with '%'. Default is *. */
        private string $wildcard = '*'
    ) {
    }

    /**
     * Applies the criteria - if more than one value is separated by the configured separator we will "OR" all the params.
     *
     * @psalm-param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder | EagerLoadPivotBuilder
    {
        return $model->where(function (Builder | EagerLoadPivotBuilder $query) {
            $values = explode($this->separator, $this->valueString);
            $query->where($this->field, 'LIKE', str_replace($this->wildcard, '%', array_shift($values)));
            foreach ($values as $value) {
                $query->orWhere($this->field, 'LIKE', str_replace($this->wildcard, '%', $value));
            }
        });
    }
}

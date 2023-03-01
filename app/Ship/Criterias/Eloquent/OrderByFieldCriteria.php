<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Support\Str;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class OrderByFieldCriteria extends Criteria
{
    private string $sortOrder;

    public function __construct(private string $field, string $sortOrder)
    {
        $sortOrder           = Str::lower($sortOrder);
        $availableDirections = [
            'asc',
            'desc',
        ];

        // check if the value is available, otherwise set "default" sort order to ascending!
        if (!in_array($sortOrder, $availableDirections)) {
            $sortOrder = 'asc';
        }

        $this->sortOrder = $sortOrder;
    }

    /**
     * @psalm-param EloquentBuilder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): EloquentBuilder
    {
        return $model->orderBy($this->field, $this->sortOrder);
    }
}

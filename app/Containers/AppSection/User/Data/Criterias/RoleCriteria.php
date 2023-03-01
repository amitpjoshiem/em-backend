<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Data\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class RoleCriteria extends Criteria
{
    public function __construct(private string $roles)
    {
    }

    /**
     * @psalm-param EloquentBuilder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): EloquentBuilder
    {
        return $model->whereHas('roles', function (EloquentBuilder $q) {
            $q->where('name', $this->roles);
        });
    }
}

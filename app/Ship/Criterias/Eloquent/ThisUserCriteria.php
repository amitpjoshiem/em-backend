<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class ThisUserCriteria extends Criteria
{
    public function __construct(private ?int $userId = null)
    {
    }

    /**
     * @psalm-param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        $this->userId ??= Auth::user()->id;

        $table = $model->getModel()->getTable();

        return $model->where("{$table}.user_id", '=', $this->userId);
    }
}

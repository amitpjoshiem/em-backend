<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Data\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereHasModelCriteria extends Criteria
{
    public function __construct(private Model $model, private ?string $collection = null)
    {
    }

    /**
     * @param Builder|Model $model
     *
     * @return Builder|Model
     *
     * @psalm-return Builder<Model>|Model
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->whereHasMorph(
            'model',
            [$this->model::class],
            function (Builder $builder) {
                $builder->where($this->model->getKeyName(), $this->model->getKey());
                $builder->when($this->collection, function (Builder $builder) {
                    $builder->where('collection', $this->collection);
                });
            }
        );
    }
}

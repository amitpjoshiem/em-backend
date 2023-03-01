<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Data\Criterias;

use App\Containers\AppSection\Media\Models\TemporaryUpload;
use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereHasTemporaryUploadCriteria extends Criteria
{
    public function __construct(private array $uuids, private ?string $collection = null)
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
            [TemporaryUpload::class],
            function (Builder $builder) {
                $builder->whereIn('uuid', $this->uuids);
                $builder->when($this->collection, function (Builder $builder) {
                    $builder->where('collection', $this->collection);
                });
            }
        );
    }
}

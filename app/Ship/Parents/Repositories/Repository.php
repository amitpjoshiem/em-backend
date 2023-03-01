<?php

namespace App\Ship\Parents\Repositories;

use App\Ship\Core\Abstracts\Repositories\Repository as AbstractRepository;
use App\Ship\Parents\Models\Model;
use Illuminate\Container\Container as Application;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Exceptions\RepositoryException;

abstract class Repository extends AbstractRepository
{
    public function __construct(Application $app, protected DatabaseManager $db)
    {
        parent::__construct($app);
    }

    /**
     * Boot up the repository, pushing criteria.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Delete multiple entities in repository by Criteria.
     *
     * @throws RepositoryException
     * @throws \Exception
     */
    public function deleteByCriteria(): bool
    {
        if ($this->skipCriteria === true) {
            return false;
        }

        if ($this->getCriteria()->count() === 0) {
            return false;
        }

        $this->applyCriteria();
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $deleted = $this->model->delete();

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();
        $this->resetScope();

        return (bool)$deleted;
    }

    /**
     * Update multiple entities in repository by Criteria.
     *
     * @throws RepositoryException
     */
    public function updateByCriteria(array $attributes): Collection | bool
    {
        if ($this->skipCriteria === true) {
            return false;
        }

        if ($this->getCriteria()->count() === 0) {
            return false;
        }

        $this->applyCriteria();
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;

        $this->skipPresenter(true);

        $updated = $this->model->update($attributes);

        if ($updated === 0) {
            return false;
        }

        $model = $this->model->get();

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($model);
    }

    /**
     * @return array<array-key, int>
     */
    public function massUpdateViaChecksConditions(array $updatableData, ?string $primaryKey = null): array
    {
        $casesList  = [];
        $paramsList = [];
        $listOfIds  = [];
        $primaryKey ??= $this->model->getKeyName();

        foreach ($updatableData as $id => $input) {
            foreach ($input as $field => $value) {
                $casesList[$field][]  = "WHEN {$id} THEN ?";
                $paramsList[$field][] = $value;
                $listOfIds[$field][]  = $id;
            }
        }

        $result     = [];
        $fieldsUsed = array_keys($listOfIds);

        foreach ($fieldsUsed as $key) {
            $ids   = implode(',', $listOfIds[$key]);
            $cases = implode(' ', $casesList[$key]);

            $result[$key] = $this->db->update("UPDATE `{$this->model->getTable()}` SET `{$key}` = CASE `{$primaryKey}` {$cases} END WHERE `{$primaryKey}` in ({$ids})", $paramsList[$key]);
        }

        return $result;
    }

    /**
     * @throws RepositoryException
     */
    public function getBuilder(): Builder
    {
        $this->applyCriteria();
        $this->applyScope();

        $query = $this->model->getQuery();

        $this->resetModel();
        $this->resetScope();

        return $query;
    }

    /**
     * @param int $modelId
     * @param string $relation
     * @param array $relationData
     * @return mixed
     */
    public function createRelation(int $modelId, string $relation, array $relationData): Model
    {
        return $this->find($modelId)->{$relation}()->create($relationData);
    }

    /**
     * @param int $modelId
     * @param string $relation
     * @param array $relationData
     * @return mixed
     */
    public function createManyRelation(int $modelId, string $relation, array $relationData): Collection
    {
        return $this->find($modelId)->{$relation}()->createMany($relationData);
    }

    /**
     * @param int $modelId
     * @param string $relation
     * @param array $relationData
     * @return mixed
     */
    public function updateRelation(int $modelId, string $relation, array $relationData): Model
    {
        $model = $this->find($modelId);
        $model->{$relation}()->update($relationData);
        return $model->{$relation};
    }

    public function withTrashed(): self
    {
        $this->model = $this->model->withTrashed();

        return $this;
    }
}

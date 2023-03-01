<?php

namespace App\Ship\Parents\Traits;

use App\Ship\Parents\Models\Pivot;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class EagerLoadPivotBuilder extends Builder
{
    protected static array $knownPivotAccessors = [
        'pivot',
    ];

    /**
     * Override.
     * Eagerly load the relationship on a set of models.
     *
     * @param string $name
     *
     * @return array
     */
    protected function eagerLoadRelation(array $models, $name, Closure $constraints)
    {
        $this->watchForPivotAccessors($name);

        try {
            return parent::eagerLoadRelation($models, $name, $constraints);
        } catch (RelationNotFoundException $e) {
            if (head($models)->{$name} instanceof Pivot) {
                if ($this->isPivotAccessor($name)) {
                    $this->eagerLoadPivotRelations($models, $name);

                    return $models;
                }
            }

            throw $e;
        }
    }

    /**
     * Watch for pivot accessors to register it as known pivot accessors.
     */
    protected function watchForPivotAccessors(string $name): void
    {
        $model = $this->getModel();

        if (!method_exists($model->newInstance(), $name)) {
            return;
        }

        $relation = $model->newInstance()->{$name}();

        if ($relation instanceof BelongsToMany) {
            static::$knownPivotAccessors[] = $relation->getPivotAccessor();
        }
    }

    /**
     * If relation name is a pivot accessor.
     */
    protected function isPivotAccessor(string $name): bool
    {
        return in_array($name, static::$knownPivotAccessors);
    }

    /**
     * Eager load pivot relations.
     */
    protected function eagerLoadPivotRelations(array $models, string $pivotAccessor): void
    {
        $pivots = Arr::pluck($models, $pivotAccessor);
        $pivots = head($pivots)->newCollection($pivots);
        $pivots->load($this->getPivotEagerLoadRelations($pivotAccessor));
    }

    /**
     * Get the pivot relations to be eager loaded.
     */
    protected function getPivotEagerLoadRelations(string $pivotAccessor): array
    {
        $relations = array_filter($this->eagerLoad, static fn ($relation) => $relation !== $pivotAccessor && Str::contains($relation, $pivotAccessor), ARRAY_FILTER_USE_KEY);

        return array_combine(
            array_map(static fn ($relation) => substr($relation, strlen("{$pivotAccessor}.")), array_keys($relations)),
            array_values($relations)
        );
    }
}

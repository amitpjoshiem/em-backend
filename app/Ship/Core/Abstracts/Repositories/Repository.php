<?php

namespace App\Ship\Core\Abstracts\Repositories;

use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CacheableInterface as PrettusCacheable;
use Prettus\Repository\Eloquent\BaseRepository as PrettusRepository;
use Prettus\Repository\Traits\CacheableRepository as PrettusCacheableRepository;

abstract class Repository extends PrettusRepository implements PrettusCacheable
{
    use PrettusCacheableRepository {
        PrettusCacheableRepository::paginate as cacheablePaginate;
    }

    /**
     * Define the maximum amount of entries per page that is returned.
     * Set to 0 to "disable" this feature.
     */
    protected int $maxPaginationLimit = 0;

    /**
     * Define the maximum amount of entries per page that is returned.
     * Set to 0 to "disable" this feature
     */
    protected ?bool $allowDisablePagination = null;

    /**
     * This function relies on strict conventions.
     * Conventions:
     *    - Repository name should be same like it's model name (model: Foo -> repository: FooRepository).
     *    - If the container contains Models with names different than the container name, the repository class must
     *          implement model() method and return the FQCN e.g. Role::class
     * Specify Model class name.
     */
    public function model(): string
    {
        // 1_ get the full namespace of the child class who's extending this class.
        // 2_ remove the namespace and keep the class name
        // 3_ remove the word Repository from the class name
        // 4_ check if the container name is set on the repository to indicate that the
        //    model has different name than the container holding it
        // 5_ build the namespace of the Model based on the conventions

        $fullName       = static::class;
        $className      = substr($fullName, strrpos($fullName, '\\') + 1);
        $classOnly      = str_replace('Repository', '', $className);
        $modelNamespace = 'App\\Containers\\' . $this->getCurrentSection() . '\\' . $this->getCurrentContainer() . '\\Models\\' . $classOnly;

        return $modelNamespace;
    }

    private function getCurrentSection(): string
    {
        return explode('\\', static::class)[2];
    }

    private function getCurrentContainer(): string
    {
        return explode('\\', static::class)[3];
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
    }

    /**
     * Paginate the response
     * Apply pagination to the response. Use ?limit= to specify the amount of entities in the response.
     * The client can request all data (skipping pagination) by applying ?limit=0 to the request, if
     * PAGINATION_SKIP is set to true.
     *
     * @param null   $limit
     * @param array  $columns
     * @param string $method
     *
     * @psalm-return mixed
     */
    public function paginate($limit = null, $columns = ['*'], $method = 'paginate')
    {
        $limit = $this->setPaginationLimit($limit);

        if ($this->wantsToSkipPagination($limit) && $this->canSkipPagination()) {
            return $this->all($columns);
        }

        if ($this->exceedsMaxPaginationLimit($limit)) {
            $limit = $this->maxPaginationLimit;
        }

        return $this->cacheablePaginate($limit, $columns, $method);
    }

    private function setPaginationLimit($limit)
    {
        // the priority is for the function parameter, if not available then take
        // it from the request if available and if not keep it null.
        return $limit ?? Request::get('limit');
    }

    private function wantsToSkipPagination($limit): bool
    {
        return $limit == "0";
    }

    private function canSkipPagination()
    {
        // check local (per repository) rule
        if (!is_null($this->allowDisablePagination)) {
            return $this->allowDisablePagination;
        }

        // check global (.env) rule
        return config('repository.pagination.skip');
    }

    private function exceedsMaxPaginationLimit($limit): bool
    {
        return $this->maxPaginationLimit > 0 && $limit > $this->maxPaginationLimit;
    }
}

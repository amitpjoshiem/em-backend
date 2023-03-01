<?php

namespace App\Ship\Core\Abstracts\Transformers;

use App\Ship\Core\Exceptions\CoreInternalErrorException;
use App\Ship\Core\Exceptions\UnsupportedFractalIncludeException;
use App\Ship\Fractal\FractalScope;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Primitive;
use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Scope;
use League\Fractal\TransformerAbstract as FractalTransformer;

abstract class Transformer extends FractalTransformer
{
    /**
     * @param $adminResponse
     * @param $clientResponse
     */
    public function ifAdmin($adminResponse, $clientResponse): array
    {
        $user = $this->user();

        if (!is_null($user) && $user->hasAdminRole()) {
            return array_merge($clientResponse, $adminResponse);
        }

        return $clientResponse;
    }

    public function user(): ?Authenticatable
    {
        return Auth::user();
    }

    /**
     * @psalm-param mixed                       $data
     * @psalm-param callable|FractalTransformer $transformer
     * @psalm-param null|string                 $resourceKey
     */
    public function item($data, $transformer, $resourceKey = null, bool $include = true): Item
    {
        // set a default resource key if none is set
        if (!$resourceKey && $data) {
            $resourceKey = $data->getResourceKey();
        }

        return parent::item($data, $transformer, $resourceKey);
    }

    /**
     * @psalm-param mixed                       $data
     * @psalm-param callable|FractalTransformer $transformer
     * @psalm-param null|string                 resourceKey
     */
    public function collection($data, $transformer, $resourceKey = null): Collection
    {
        // set a default resource key if none is set
        if (!$resourceKey && $data->isNotEmpty()) {
            $resourceKey = (string)$data->modelKeys()[0];
        }
        return parent::collection($data, $transformer, $resourceKey);
    }

    /**
     * @param string $includeName
     *
     * @throws CoreInternalErrorException
     * @throws UnsupportedFractalIncludeException
     * @noinspection PhpInternalEntityUsedInspection
     */
    protected function callIncludeMethod(Scope $scope, $includeName, $data): ResourceInterface
    {
        try {
            return parent::callIncludeMethod($scope, $includeName, $data);
        } catch (Exception $exception) {
            if (Config::get('apiato.requests.force-valid-includes', true)) {
                throw new UnsupportedFractalIncludeException($exception->getMessage());
            }
            throw new CoreInternalErrorException($exception->getMessage());
        }
    }

    /**
     * Include a resource only if it is available on the method.
     *
     * @internal
     *
     * @param FractalScope  $scope
     * @param mixed  $data
     * @param array  $includedData
     * @param string $include
     *
     * @return array
     */
    private function includeResourceIfAvailable(
        Scope $scope,
              $data,
              $includedData,
              $include
    ): array
    {
        if ($resource = $this->callIncludeMethod($scope, $include, $data)) {
            /** @var FractalScope $childScope */
            $childScope = $scope->embedChildScope($include, $resource);
            if ($childScope->getResource() instanceof Primitive) {
                $includedData[$include] = $childScope->transformPrimitiveResource();
            } else {
                $includedData[$include] = $childScope->toArray(true);
            }
        }

        return $includedData;
    }

    /**
     * This method is fired to loop through available includes, see if any of
     * them are requested and permitted for this scope.
     *
     * @param Scope $scope
     * @param mixed $data
     *
     * @return array|false
     * @internal
     *
     */
    public function processIncludedResources(FractalScope|Scope $scope, $data): bool|array
    {
        $includedData = [];

        $includes = $this->figureOutWhichIncludes($scope);

        foreach ($includes as $include) {
            $includedData = $this->includeResourceIfAvailable(
                $scope,
                $data,
                $includedData,
                $include
            );
        }

        return $includedData === [] ? false : $includedData;
    }

    /**
     * Figure out which includes we need.
     *
     * @internal
     *
     * @param Scope $scope
     *
     * @return array
     */
    private function figureOutWhichIncludes(Scope $scope)
    {
        $includes = $this->getDefaultIncludes();

        foreach ($this->getAvailableIncludes() as $include) {
            if ($scope->isRequested($include)) {
                $includes[] = $include;
            }
        }

        foreach ($includes as $include) {
            if ($scope->isExcluded($include)) {
                $includes = array_diff($includes, [$include]);
            }
        }

        return $includes;
    }
}

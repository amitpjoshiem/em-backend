<?php

namespace App\Ship\Fractal;

use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use JsonSerializable;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;
use League\Fractal\Serializer\SerializerAbstract;
use Spatie\Fractalistic\Fractal;

class ShipFractal extends Fractal implements JsonSerializable
{
    /**
     * @param null|mixed $data
     * @param null|string|callable|\League\Fractal\TransformerAbstract $transformer
     * @param null|string|\League\Fractal\Serializer\SerializerAbstract $serializer
     *
     * @return Fractal
     */
    public static function create($data = null, $transformer = null, $serializer = null)
    {
        $instance = new static(new Manager(new FractalScopeFactory()));

        $instance->data = $data;
        $instance->dataType = $instance->determineDataType($data);
        $instance->transformer = $transformer ?: null;
        $instance->serializer = $serializer ?: null;

        $fractal = $instance;
        if (config('fractal.auto_includes.enabled')) {
            $requestKey = config('fractal.auto_includes.request_key');

            if ($include = app('request')->query($requestKey)) {
                $fractal->parseIncludes($include);
            }
        }

        if (empty($serializer)) {
            $serializer = config('fractal.default_serializer');
        }

        if ($data instanceof LengthAwarePaginator) {
            $paginator = config('fractal.default_paginator');

            if (empty($paginator)) {
                $paginator = IlluminatePaginatorAdapter::class;
            }

            $fractal->paginateWith(new $paginator($data));
        }

        if (empty($serializer)) {
            return $fractal;
        }

        if ($serializer instanceof SerializerAbstract) {
            return $fractal->serializeWith($serializer);
        }

        if ($serializer instanceof Closure) {
            return $fractal->serializeWith($serializer());
        }

        if ($serializer == JsonApiSerializer::class) {
            $baseUrl = config('fractal.base_url');

            return $fractal->serializeWith(new $serializer($baseUrl));
        }

        return $fractal->serializeWith(new $serializer);
    }
}

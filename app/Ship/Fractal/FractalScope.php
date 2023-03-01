<?php

namespace App\Ship\Fractal;

use App\Ship\Serializers\DefaultSerializerInterface;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Scope;
use League\Fractal\Serializer\SerializerAbstract;

class FractalScope extends Scope
{

    private bool $include = false;
    /**
     * Convert the current data for this scope to an array.
     *
     * @return array
     */
    public function toArray(bool $include = false)
    {
        $this->include = $include;
        return parent::toArray();
    }

    /**
     * Serialize a resource
     *
     * @internal
     *
     * @param SerializerAbstract $serializer
     * @param mixed              $data
     *
     * @return array
     */
    protected function serializeResource(SerializerAbstract $serializer, $data)
    {
        $resourceKey = $this->resource->getResourceKey();

        if ($this->resource instanceof Collection) {
            if ($serializer instanceof DefaultSerializerInterface) {
                return $serializer->collection($resourceKey, $data, $this->include);
            } else {
                return $serializer->collection($resourceKey, $data);
            }
        }

        if ($this->resource instanceof Item) {
            if ($serializer instanceof DefaultSerializerInterface) {
                return $serializer->item($resourceKey, $data, $this->include);
            } else {
                return $serializer->item($resourceKey, $data);
            }
        }

        return $serializer->null();
    }
}

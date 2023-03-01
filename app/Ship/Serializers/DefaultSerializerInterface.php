<?php

namespace App\Ship\Serializers;

use League\Fractal\Pagination\CursorInterface;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Resource\ResourceInterface;

interface DefaultSerializerInterface
{

    public function collection($resourceKey, array $data, bool $include = false);

    public function item($resourceKey, array $data, bool $include = false);
}

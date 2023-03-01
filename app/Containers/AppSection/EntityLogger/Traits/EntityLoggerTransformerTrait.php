<?php

declare(strict_types=1);

namespace App\Containers\AppSection\EntityLogger\Traits;

use App\Containers\AppSection\EntityLogger\UI\API\Transformers\EntityLoggerTransformer;
use App\Ship\Parents\Models\Model;

trait EntityLoggerTransformerTrait
{
    public function includeLogs(mixed $data)
    {
        if ($data instanceof Model) {
            return $this->collection($data->logs, new EntityLoggerTransformer(), 'logs');
        }

        return $this->null();
    }
}

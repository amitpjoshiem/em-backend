<?php

declare(strict_types=1);

namespace App\Containers\AppSection\EntityLogger\UI\API\Controllers;

use App\Containers\AppSection\EntityLogger\Actions\GetAllEntityLoggersAction;
use App\Containers\AppSection\EntityLogger\UI\API\Requests\GetAllEntityLoggersRequest;
use App\Containers\AppSection\EntityLogger\UI\API\Transformers\EntityLoggerTransformer;
use App\Ship\Parents\Controllers\ApiController;

class Controller extends ApiController
{
    public function getAllEntityLoggers(GetAllEntityLoggersRequest $request): array
    {
        $entityLogs = app(GetAllEntityLoggersAction::class)->run();

        return $this->transform($entityLogs, EntityLoggerTransformer::class);
    }
}

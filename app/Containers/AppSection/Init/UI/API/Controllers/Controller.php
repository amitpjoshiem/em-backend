<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Init\UI\API\Controllers;

use App\Containers\AppSection\Init\Actions\GetAllInitAction;
use App\Containers\AppSection\Init\UI\API\Transformers\InitTransformer;
use App\Ship\Parents\Controllers\ApiController;

class Controller extends ApiController
{
    public function getAllInit(): array
    {
        $init = app(GetAllInitAction::class)->run();

        return $this->transform($init, InitTransformer::class, resourceKey:  'init');
    }
}

<?php

namespace App\Ship\Parents\Controllers;

use App\Ship\Core\Abstracts\Controllers\ApiController as AbstractApiController;
use App\Ship\Parents\Traits\ResponseWithPostProcessTrait;

abstract class ApiController extends AbstractApiController
{
    use ResponseWithPostProcessTrait;
}

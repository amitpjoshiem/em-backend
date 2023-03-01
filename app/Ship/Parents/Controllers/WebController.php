<?php

namespace App\Ship\Parents\Controllers;

use App\Ship\Core\Abstracts\Controllers\WebController as AbstractWebController;
use App\Ship\Core\Traits\ResponseTrait;

abstract class WebController extends AbstractWebController
{
    use ResponseTrait;
}

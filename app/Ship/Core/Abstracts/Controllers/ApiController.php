<?php

namespace App\Ship\Core\Abstracts\Controllers;

use App\Ship\Core\Traits\ResponseTrait;

abstract class ApiController extends Controller
{
    use ResponseTrait;

    /**
     * The type of this controller. This will be accessible mirrored in the Actions.
     * Giving each Action the ability to modify it's internal business logic based on the UI type that called it.
     */
    public string $ui = 'api';
}

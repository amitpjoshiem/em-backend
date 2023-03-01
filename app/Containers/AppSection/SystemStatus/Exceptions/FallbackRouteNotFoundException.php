<?php

declare(strict_types=1);

namespace App\Containers\AppSection\SystemStatus\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class FallbackRouteNotFoundException extends Exception
{
    /**
     * @var int
     */
    public $code    = Response::HTTP_NOT_FOUND;

    /**
     * @var string
     */
    public $message = 'Not Found!';
}

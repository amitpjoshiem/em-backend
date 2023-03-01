<?php

declare(strict_types=1);

namespace App\Containers\AppSection\SystemStatus\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class SessionFailedException extends Exception
{
    /**
     * @var int
     */
    public $code    = Response::HTTP_SERVICE_UNAVAILABLE;

    /**
     * @var string
     */
    public $message = 'Session does not works as expected';
}

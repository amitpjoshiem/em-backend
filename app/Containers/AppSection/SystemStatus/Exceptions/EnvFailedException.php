<?php

declare(strict_types=1);

namespace App\Containers\AppSection\SystemStatus\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class EnvFailedException extends Exception
{
    /**
     * @var int
     */
    public $code = Response::HTTP_SERVICE_UNAVAILABLE;
}

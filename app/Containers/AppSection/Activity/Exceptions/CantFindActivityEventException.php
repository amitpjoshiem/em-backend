<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class CantFindActivityEventException extends Exception
{
    /**
     * @var int
     */
    protected $code    = Response::HTTP_UNAUTHORIZED;

    /**
     * @var string
     */
    protected $message = 'Wrong Activity Type';
}

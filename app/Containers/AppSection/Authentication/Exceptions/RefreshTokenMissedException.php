<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class RefreshTokenMissedException extends Exception
{
    /**
     * @var int
     */
    protected $code    = Response::HTTP_BAD_REQUEST;

    /**
     * @var string
     */
    protected $message = 'We could not find the Refresh Token. Maybe none is provided?';
}

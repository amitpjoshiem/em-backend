<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationUserException extends Exception
{
    /**
     * @var int
     */
    protected $code    = Response::HTTP_UNAUTHORIZED;

    /**
     * @var string
     */
    protected $message = 'An Exception was thrown while trying to get an authenticated User.';
}

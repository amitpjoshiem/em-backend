<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class LoginFailedException extends Exception
{
    /**
     * @var int
     */
    protected $code    = Response::HTTP_BAD_REQUEST;

    /**
     * @var string
     */
    protected $message = 'An Exception happened during the Login Process.';
}

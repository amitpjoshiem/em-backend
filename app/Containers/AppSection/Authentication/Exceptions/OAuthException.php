<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class OAuthException extends Exception
{
    /**
     * @var int
     */
    protected $code    = Response::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * @var string
     */
    protected $message = 'OAuth 2.0 is not installed.';
}

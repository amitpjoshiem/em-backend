<?php

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class InternalErrorException extends Exception
{
    protected $code    = Response::HTTP_INTERNAL_SERVER_ERROR;

    protected $message = 'Something went wrong!';
}

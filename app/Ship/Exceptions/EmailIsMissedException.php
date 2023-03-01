<?php

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class EmailIsMissedException extends Exception
{
    protected $code    = Response::HTTP_INTERNAL_SERVER_ERROR;

    protected $message = 'One of the Emails is missed, check your configs..';
}

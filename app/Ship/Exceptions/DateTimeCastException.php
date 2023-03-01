<?php

declare(strict_types=1);

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class DateTimeCastException extends Exception
{
    protected $code    = Response::HTTP_UNPROCESSABLE_ENTITY;

    protected $message = 'Invalid Date Format';
}

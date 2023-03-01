<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class OtpVerifyException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_FORBIDDEN;

    /**
     * @var string
     */
    protected $message = 'Invalid Code';
}

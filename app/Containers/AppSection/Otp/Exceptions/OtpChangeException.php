<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class OtpChangeException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_FORBIDDEN;

    /**
     * @var string
     */
    protected $message = 'Can`t change OTP to this service';
}

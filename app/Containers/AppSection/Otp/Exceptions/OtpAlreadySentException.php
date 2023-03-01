<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class OtpAlreadySentException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_TOO_EARLY;

    /**
     * @var string
     */
    protected $message = 'OTP already Sent. Please, try again later.';
}

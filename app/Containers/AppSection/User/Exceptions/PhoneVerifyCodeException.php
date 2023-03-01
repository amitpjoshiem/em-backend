<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class PhoneVerifyCodeException extends Exception
{
    /**
     * @var int
     */
    public $code    = Response::HTTP_BAD_REQUEST;

    /**
     * @var string
     */
    public $message = 'Incorrect phone verify code';
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Sms\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class UserNotVerifyPhoneException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_BAD_REQUEST;

    /**
     * @var string
     */
    protected $message = 'User didn`t verify phone number';
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class UserNotConfirmedException extends Exception
{
    /**
     * @var int
     */
    protected $code    = Response::HTTP_CONFLICT;

    /**
     * @var string
     */
    protected $message = 'The user email is not confirmed yet. Please verify your email before trying to login.';
}

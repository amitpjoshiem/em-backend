<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class UserNotAdminException extends Exception
{
    /**
     * @var int
     */
    protected $code    = Response::HTTP_FORBIDDEN;

    /**
     * @var string
     */
    protected $message = 'This User does not have an Admin permission.';
}

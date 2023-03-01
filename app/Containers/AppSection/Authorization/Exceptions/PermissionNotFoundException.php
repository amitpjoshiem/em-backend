<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class PermissionNotFoundException extends Exception
{
    /**
     * @var int
     */
    protected $code    = Response::HTTP_NOT_FOUND;

    /**
     * @var string
     */
    protected $message = 'The requested Permission(s) was not found.';
}

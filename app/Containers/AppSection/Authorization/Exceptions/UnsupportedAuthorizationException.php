<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class UnsupportedAuthorizationException extends Exception
{
    /**
     * @var int
     */
    protected $code    = Response::HTTP_PRECONDITION_FAILED;

    /**
     * @var string
     */
    protected $message = 'Unsupportable Condition';
}

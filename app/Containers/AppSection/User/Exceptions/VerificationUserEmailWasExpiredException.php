<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class VerificationUserEmailWasExpiredException extends Exception
{
    /**
     * @var int
     */
    public $code    = Response::HTTP_CONFLICT;

    /**
     * @var string
     */
    public $message = 'Verification period was expired.';
}

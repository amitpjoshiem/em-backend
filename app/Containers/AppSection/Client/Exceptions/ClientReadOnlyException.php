<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class ClientReadOnlyException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_LOCKED;

    /**
     * @var string
     */
    protected $message = 'You Have only Read Only Access';
}

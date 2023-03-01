<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class CantSubmitClientException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_BAD_REQUEST;

    /**
     * @var string
     */
    protected $message = 'Can`t Submit Client Info';
}

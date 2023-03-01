<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class CantFindContactException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_BAD_REQUEST;

    /**
     * @var string
     */
    protected $message = 'Can`t Find Contacts with this ID';
}

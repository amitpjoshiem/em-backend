<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class RowAlreadyExistException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_BAD_REQUEST;

    /**
     * @var string
     */
    protected $message = 'Row Already Exist.';
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class WrongHouseTypeException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;

    /**
     * @var string
     */
    protected $message = 'Wrong House Type';
}

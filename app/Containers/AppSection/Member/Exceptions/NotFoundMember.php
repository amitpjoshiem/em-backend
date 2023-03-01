<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class NotFoundMember extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_NOT_FOUND;

    /**
     * @var string
     */
    protected $message = 'Don`t found Member with this ID';
}

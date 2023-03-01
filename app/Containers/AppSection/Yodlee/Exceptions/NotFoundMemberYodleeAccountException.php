<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class NotFoundMemberYodleeAccountException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_BAD_REQUEST;

    /**
     * @var string
     */
    protected $message = 'Member doesn`t have yodlee account';
}

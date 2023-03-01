<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class SalesforceUserAlreadyExistException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_BAD_REQUEST;

    /**
     * @var string
     */
    protected $message = 'This Salesforce User already logged in';
}

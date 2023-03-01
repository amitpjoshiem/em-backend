<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class SalesforceDescribeException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_BAD_REQUEST;
}

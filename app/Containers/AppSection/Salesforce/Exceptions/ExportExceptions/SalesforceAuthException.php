<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Exceptions\ExportExceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class SalesforceAuthException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_BAD_REQUEST;

    /**
     * @var string
     */
    protected $message = 'Could not authenticate in Salesforce';
}

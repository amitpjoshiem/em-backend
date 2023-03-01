<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Exceptions\ExportExceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class OwnerNotExistException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * @var string
     */
    protected $message = 'Owner Not Exist for this Salesforce Object';
}

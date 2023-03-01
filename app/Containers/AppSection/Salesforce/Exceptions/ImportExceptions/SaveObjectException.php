<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Exceptions\ImportExceptions;

use App\Containers\AppSection\Salesforce\Data\Transporters\SaveObjectExceptionTransporter;
use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class SaveObjectException extends Exception
{
    public function __construct(public SaveObjectExceptionTransporter $data)
    {
        parent::__construct();
    }

    /**
     * @var int
     */
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * @var string
     */
    protected $message = 'Save Object Exception';
}

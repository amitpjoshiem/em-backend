<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Exceptions\ImportExceptions;

use App\Ship\Parents\Exceptions\Exception;
use Exception as BaseException;
use Symfony\Component\HttpFoundation\Response;

class FindObjectInfoException extends Exception
{
    public function __construct(public string $salesforce_id, public string $object, public BaseException $exception)
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

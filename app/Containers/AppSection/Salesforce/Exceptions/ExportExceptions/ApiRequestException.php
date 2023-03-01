<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Exceptions\ExportExceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class ApiRequestException extends Exception
{
    public function __construct(public string $method, public string $url, public array $responseData, public array $requestData, public bool $isAuth = false)
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
    protected $message = 'Api Exception';
}

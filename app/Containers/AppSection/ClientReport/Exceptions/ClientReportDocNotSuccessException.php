<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class ClientReportDocNotSuccessException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_BAD_REQUEST;

    /**
     * @var string
     */
    protected $message = 'Client Report Doc not success status';
}

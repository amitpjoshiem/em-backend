<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class CantFindClientReportDocException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_BAD_REQUEST;

    /**
     * @var string
     */
    protected $message = 'Cant Find Client Report Doc By ID';
}

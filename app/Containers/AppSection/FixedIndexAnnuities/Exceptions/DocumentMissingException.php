<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class DocumentMissingException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * @var string
     */
    protected $message = 'Document missing';
}

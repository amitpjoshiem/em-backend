<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class DocumentAlreadyCompletedException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_BAD_REQUEST;

    /**
     * @var string
     */
    protected $message = 'Document Already Completed';
}

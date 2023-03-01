<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class UnacceptableFileType extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;

    /**
     * @var string
     */
    protected $message = 'Unacceptable File Type For This Collection';
}

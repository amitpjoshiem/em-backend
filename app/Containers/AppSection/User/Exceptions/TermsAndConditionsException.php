<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class TermsAndConditionsException extends Exception
{
    /**
     * @var int
     */
    public $code   = Response::HTTP_UNPROCESSABLE_ENTITY;

    /**
     * @var string
     */
    public $message = 'User does not agree with Terms And Conditions';
}

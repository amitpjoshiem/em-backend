<?php

namespace App\Ship\Parents\Exceptions;

use App\Ship\Parents\TransformerPostProcessors\TransformerPostProcessor;
use Symfony\Component\HttpFoundation\Response;

class InvalidTransformerPostProcessorException extends Exception
{
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;

    protected $message = 'TransformerPostProcessors must extended the ' . TransformerPostProcessor::class . ' class.';
}

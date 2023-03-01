<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Exceptions\ImportExceptions;

use App\Ship\Parents\Exceptions\Exception;
use Exception as BaseException;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class MultipleExceptions extends Exception
{
    protected Collection $exceptions;

    public function __construct(?string $message = null, ?int $code = null, ?BaseException $previous = null, ?array $logContext = null)
    {
        $this->exceptions = collect();

        parent::__construct($message, $code, $previous, $logContext);
    }

    /**
     * @var int
     */
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * @var string
     */
    protected $message = 'Multiple Import Exceptions';

    public function addException(BaseException $exception): void
    {
        $this->exceptions->push($exception);
    }

    public function getExceptions(): Collection
    {
        return $this->exceptions;
    }
}

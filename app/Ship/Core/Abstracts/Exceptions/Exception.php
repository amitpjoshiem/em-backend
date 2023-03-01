<?php

namespace App\Ship\Core\Abstracts\Exceptions;

use Exception as BaseException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

abstract class Exception extends BaseException
{
    private const DEFAULT_STATUS_CODE = 500;

    protected string $environment;

    protected $message;

    protected $code;

    protected array $errors = [];

    public function __construct(
        ?string $message = null,
        ?int $code = null,
        ?BaseException $previous = null,
        ?array $logContext = null
    ) {
        // Detect and set the running environment
        $this->environment = Config::get('app.env');

        $this->message = $this->prepareMessage($message);
        $this->code    = $this->prepareStatusCode($code);

        if ($logContext !== null) {
            Log::error($this->message, $logContext);
        }

        parent::__construct($this->message, $this->code, $previous);
    }

    /**
     * Help developers debug the error without showing these details to the end user.
     * Usage: `throw (new MyCustomException())->debug($e)`.
     *
     * @param $error
     * @param $force
     */
    public function debug($error, bool $force = false): self
    {
        if ($error instanceof BaseException) {
            $error = $error->getMessage();
        }

        if ($this->environment !== 'testing' || $force === true) {
            Log::error('[DEBUG] ' . $error);
        }

        return $this;
    }

    public function withErrors(array $errors, bool $override = true): self
    {
        if ($override) {
            $this->errors = $errors;
        } else {
            $this->errors = array_merge($this->errors, $errors);
        }

        return $this;
    }

    public function getErrors(): array
    {
        $translatedErrors = [];

        foreach ($this->errors as $key => $value) {
            $translatedValues = [];
            // here we translate and mutate each error so all error values will be arrays (for consistency)
            // e.g. error => value becomes error => [translated_value]
            // e.g. error => [value1, value2] becomes error => [translated_value1, translated_value2]
            if (is_array($value)) {
                foreach ($value as $translationKey) {
                    $translatedValues[] = __($translationKey);
                }
            } else {
                $translatedValues[] = __($value);
            }

            $translatedErrors[$key] = $translatedValues;
        }

        return $translatedErrors;
    }

    private function prepareMessage(?string $message = null): ?string
    {
        return is_null($message) ? $this->message : $message;
    }

    private function prepareStatusCode(?int $code = null): int
    {
        return is_null($code) ? $this->findStatusCode() : $code;
    }

    private function findStatusCode(): int
    {
        return $this->code ?? self::DEFAULT_STATUS_CODE;
    }

    public function getRootMessage(): string
    {
        $previousException = $this->getPrevious();
        while ($previousException !== null && $previousException->getPrevious() instanceof BaseException) {
            $previousException = $previousException->getPrevious();
        }

        return $previousException?->getMessage() ?? $this->getMessage();
    }

    public function getRootTrace(): string
    {
        $previousException = $this->getPrevious();
        while ($previousException !== null && $previousException->getPrevious() instanceof BaseException) {
            $previousException = $previousException->getPrevious();
        }

        return $previousException?->getTraceAsString()  ?? $this->getTraceAsString();
    }
}

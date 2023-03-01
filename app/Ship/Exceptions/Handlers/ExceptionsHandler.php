<?php

namespace App\Ship\Exceptions\Handlers;

use App\Ship\Core\Exceptions\Handlers\ExceptionsHandler as CoreExceptionsHandler;
use App\Ship\Parents\Exceptions\Exception as ParentException;
use Throwable;

/**
 * Class ExceptionsHandler.
 *
 * A.K.A (app/Exceptions/Handler.php)
 */
class ExceptionsHandler extends CoreExceptionsHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [

    ];

    /**
     * A list of the internal exception types that should not be reported.
     *
     * @var string[]
     */
    protected $internalDontReport = [

    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            // idle
        });

        $this->renderable(function (ParentException $e) {
            $response = [
                'message' => $e->getMessage(),
                'errors'  => $e->getErrors(),
            ];

            if (config('app.debug')) {
                $response = array_merge($response, [
                    'exception' => static::class,
                    'file'      => $e->getFile(),
                    'line'      => $e->getLine(),
                    'trace'     => $e->gettrace(),
                ]);
            }

            return response()->json($response, $e->getCode());
        });

        $this->reportable(function (Throwable $e) {
            if ($this->shouldReport($e) && app()->bound('sentry')) {
                if ($e->getCode() >= 500) {
                    app('sentry')->captureException($e);
                }
            }
        });
    }

    /**
     * Report or log an exception.
     *
     * @return void
     *
     * @throws Throwable
     */
    public function report(Throwable $e)
    {
        if ($this->shouldReport($e) && app()->bound('sentry')) {
            if ($e->getCode() >= 500) {
                app('sentry')->captureException($e);
            }
        }

        parent::report($e);
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Middlewares;

use App\Containers\AppSection\Otp\Actions\RefreshOtpTokenAction;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Middlewares\Middleware;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class OtpRefresh extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param string|null ...$guards
     *
     * @return JsonResponse
     *
     * @throws CreateResourceFailedException
     * @throws ValidatorException|UserNotFoundException
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        /** @var JsonResponse $response */
        $response = $next($request);

        $uuid = $request->cookie(config('appSection-otp.otp_cookie_name'));

        if ($uuid !== null && \is_string($uuid)) {
            $otpCookie = app(RefreshOtpTokenAction::class)->run($uuid);

            $response->withCookie($otpCookie);
        }

        return $response;
    }
}

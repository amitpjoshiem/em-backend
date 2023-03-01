<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Middlewares;

use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Ship\Parents\Middlewares\Middleware;
use Closure;
use Cookie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OtpLogout extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param string|null ...$guards
     *
     * @return JsonResponse
     *
     * @throws UserNotFoundException
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        /** @var JsonResponse $response */
        $response = $next($request);

        $cookie = Cookie::forget(config('appSection-otp.otp_cookie_name'));

        $response->withCookie($cookie);

        return $response;
    }
}

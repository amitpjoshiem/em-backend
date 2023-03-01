<?php

namespace App\Ship\Middlewares\Http;

use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Exceptions\AuthenticationException;
use Exception;
use Illuminate\Auth\Middleware\Authenticate as LaravelAuthenticate;
use Illuminate\Http\Request;

class Authenticate extends LaravelAuthenticate
{
    /**
     * @inheritDoc
     */
    public function authenticate($request, array $guards): void
    {
        try {
            parent::authenticate($request, $guards);
        } catch (Exception) {
            if ($request->expectsJson()) {
                throw new AuthenticationException();
            } else {
                $this->unauthenticated($request, $guards);
            }
        }
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @psalm-param Request $request
     */
    protected function redirectTo($request): string
    {
        return route(Apiato::getLoginWebPageName());
    }
}

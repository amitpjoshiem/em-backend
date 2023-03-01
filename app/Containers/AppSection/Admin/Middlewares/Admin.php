<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Middlewares;

use App\Containers\AppSection\Authentication\Actions\WebLogoutAction;
use App\Ship\Parents\Providers\RoutesProvider;
use Closure;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;

class Admin
{
    public function __construct(private AuthManager $auth)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param string|null ...$guards
     *
     * @psalm-return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (!$request->user()->hasRole('admin')) {
            app(WebLogoutAction::class)->run();

            return redirect(RoutesProvider::HOME);
        }

        return $next($request);
    }
}

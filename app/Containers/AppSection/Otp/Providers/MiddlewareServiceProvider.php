<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Providers;

use App\Containers\AppSection\Otp\Middlewares\OtpLogin;
use App\Containers\AppSection\Otp\Middlewares\OtpLogout;
use App\Containers\AppSection\Otp\Middlewares\OtpRefresh;
use App\Ship\Parents\Providers\MiddlewareProvider;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class MiddlewareServiceProvider extends MiddlewareProvider
{
    protected array $routeMiddleware = [
        'otp_refresh'   => OtpRefresh::class,
        'otp_login'     => OtpLogin::class,
        'otp_logout'    => OtpLogout::class,
    ];

    public function boot(): void
    {
        parent::boot();

        if (config('auth.otp')) {
            /** @var Router $router */
            $router = $this->app['router'];
            /** @psalm-suppress UndefinedInterfaceMethod */
            $routes = $router->getRoutes()->getIterator();
            /** @var Route $route */
            foreach ($routes as $route) {
                if ($route->getName() === config('appSection-otp.auth_routes.refresh')) {
                    $route->middleware(['otp_refresh']);
                }

                if ($route->getName() === config('appSection-otp.auth_routes.login')) {
                    $route->middleware(['otp_login']);
                }

                if ($route->getName() === config('appSection-otp.auth_routes.logout')) {
                    $route->middleware(['otp_logout']);
                }
            }
        }
    }
}

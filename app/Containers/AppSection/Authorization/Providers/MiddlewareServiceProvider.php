<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Providers;

use App\Ship\Parents\Providers\MiddlewareProvider;
use Illuminate\Auth\Middleware\Authorize;

class MiddlewareServiceProvider extends MiddlewareProvider
{
    protected array $routeMiddleware = [
        // Laravel default route middleware's:
        'can' => Authorize::class,
    ];
}

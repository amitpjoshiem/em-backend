<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Providers;

use App\Containers\AppSection\Authentication\Middlewares\NotAuthenticated;
use App\Ship\Parents\Providers\MiddlewareProvider;

class MiddlewareServiceProvider extends MiddlewareProvider
{
    protected array $routeMiddleware = [
        // Apiato User Authentication middleware for API and Web Pages.
        'guest' => NotAuthenticated::class,
    ];
}

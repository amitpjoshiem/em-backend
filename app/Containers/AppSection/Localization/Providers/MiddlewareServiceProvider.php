<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Localization\Providers;

use App\Containers\AppSection\Localization\Middlewares\LocalizationMiddleware;
use App\Ship\Parents\Providers\MiddlewareProvider;

class MiddlewareServiceProvider extends MiddlewareProvider
{
    /**
     * Register Container Middleware Groups.
     */
    protected array $middlewareGroups = [
        'web' => [
            LocalizationMiddleware::class,
        ],
        'api' => [
            LocalizationMiddleware::class,
        ],
    ];
}

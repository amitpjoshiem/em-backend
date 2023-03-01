<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Providers;

use App\Containers\AppSection\Admin\Middlewares\Admin;
use App\Ship\Parents\Providers\MiddlewareProvider;

class MiddlewareServiceProvider extends MiddlewareProvider
{
    /**
     * @psalm-var array<array-key, string>
     */
    protected array $routeMiddleware = [
        'admin' => Admin::class,
    ];
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Providers;

use App\Containers\AppSection\Client\Middlewares\ClientReadOnlyMiddleware;
use App\Ship\Parents\Providers\MiddlewareProvider;

class MiddlewareServiceProvider extends MiddlewareProvider
{
    /**
     * @psalm-var array<array-key, string>
     */
    protected array $routeMiddleware = [
        'client_readonly'   => ClientReadOnlyMiddleware::class,
    ];
}

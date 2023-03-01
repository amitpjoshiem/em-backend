<?php

namespace App\Ship\Core\Abstracts\Providers;

use App\Ship\Core\Loaders\MiddlewaresLoaderTrait;

abstract class MiddlewareProvider extends MainProvider
{
    use MiddlewaresLoaderTrait;

    protected array $middlewares = [];

    protected array $middlewareGroups = [];

    protected array $middlewarePriority = [];

    protected array $routeMiddleware = [];

    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        $this->loadMiddlewares();
    }

    /**
     * Register anything in the container.
     */
    public function register(): void
    {
    }
}

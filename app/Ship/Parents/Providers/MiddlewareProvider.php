<?php

namespace App\Ship\Parents\Providers;

use App\Ship\Core\Abstracts\Providers\MiddlewareProvider as AbstractMiddlewareProvider;

abstract class MiddlewareProvider extends AbstractMiddlewareProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Register anything in the container.
     */
    public function register(): void
    {
        parent::register();
    }
}

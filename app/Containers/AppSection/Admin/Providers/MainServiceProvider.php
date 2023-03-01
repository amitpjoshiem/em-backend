<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Providers;

use App\Ship\Parents\Providers\MainProvider;

/**
 * The Main Service Provider of this container, it will be automatically registered in the framework.
 */
class MainServiceProvider extends MainProvider
{
    public array $serviceProviders = [
        MiddlewareServiceProvider::class,
    ];

    public array $aliases = [
    ];

    public function register(): void
    {
        parent::register();
    }
}

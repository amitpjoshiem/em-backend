<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Providers;

use App\Ship\Parents\Providers\MainProvider;
use Spatie\Permission\PermissionServiceProvider;

class MainServiceProvider extends MainProvider
{
    /**
     * Container Service Providers.
     */
    public array $serviceProviders = [
        PermissionServiceProvider::class,
        MiddlewareServiceProvider::class,
    ];
}

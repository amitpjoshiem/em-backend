<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Documentation\Providers;

use App\Ship\Parents\Providers\MainProvider;

/**
 * Class MainServiceProvider.
 *
 * The Main Service Provider of this container, it will be automatically registered in the framework.
 */
class MainServiceProvider extends MainProvider
{
    /**
     * Container Service Providers.
     */
    public array $serviceProviders = [
    ];

    /**
     * Container Aliases.
     */
    public array $aliases = [
    ];
}

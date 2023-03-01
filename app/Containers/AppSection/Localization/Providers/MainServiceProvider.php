<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Localization\Providers;

use App\Ship\Parents\Providers\MainProvider;
use Carbon\Laravel\ServiceProvider;

class MainServiceProvider extends MainProvider
{
    public array $serviceProviders = [
        MiddlewareServiceProvider::class,
        ServiceProvider::class,
    ];
}

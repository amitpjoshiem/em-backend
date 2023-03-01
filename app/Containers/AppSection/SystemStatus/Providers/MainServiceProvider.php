<?php

declare(strict_types=1);

namespace App\Containers\AppSection\SystemStatus\Providers;

use App\Ship\Parents\Providers\MainProvider;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Telescope\Console\PruneCommand;
use Sentry\Laravel\Facade;
use Sentry\Laravel\ServiceProvider as SentryLaravelServiceProvider;
use Sentry\Laravel\Tracing\ServiceProvider;

class MainServiceProvider extends MainProvider
{
    /**
     * Container Service Providers.
     */
    public array $serviceProviders = [
        // Sentry
        SentryLaravelServiceProvider::class,
        ServiceProvider::class,
    ];

    /**
     * Container Aliases.
     */
    public array $aliases = [
        // Sentry
        'Sentry'      => Facade::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(PruneCommand::class, ['--hours=120'])->daily();
    }
}

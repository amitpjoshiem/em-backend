<?php

namespace App\Ship\Parents\Providers;

use App\Ship\Core\Abstracts\Providers\MainProvider as AbstractMainProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;

abstract class MainProvider extends AbstractMainProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        parent::boot();

        if ($this->app->runningInConsole()) {
            $this->app->booted(function (Application $app) {
                $this->schedule($app->make(Schedule::class));
            });
        }
    }

    /**
     * Register anything in the container.
     */
    public function register(): void
    {
        parent::register();
    }

    protected function schedule(Schedule $schedule): void
    {
    }
}

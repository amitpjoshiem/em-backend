<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Providers;

use App\Containers\AppSection\Authentication\Contracts\AuthenticatedModel;
use App\Containers\AppSection\Authentication\Services\AuthenticatedUser;
use App\Ship\Parents\Providers\MainProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Laravel\Passport\PassportServiceProvider;

class MainServiceProvider extends MainProvider
{
    public array $serviceProviders = [
        PassportServiceProvider::class,
        AuthProvider::class,
        MiddlewareServiceProvider::class,
        EventServiceProvider::class,
        CacheTokenServiceProvider::class,
    ];

    public function boot(): void
    {
        parent::boot();

        if (config('apiato.api.enabled-schedule-passport-purge')) {
            $this->app->booted(function (Application $app): void {
                $app->make(Schedule::class)->command('passport:purge')->hourly();
            });
        }
    }

    public function register(): void
    {
        parent::register();

        $this->app->bind(AuthenticatedModel::class, AuthenticatedUser::class);
    }
}

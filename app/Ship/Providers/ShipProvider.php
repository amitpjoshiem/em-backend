<?php

namespace App\Ship\Providers;

use App\Ship\Parents\Providers\MainProvider;
use App\Ship\Parents\Providers\RoutesProvider;
use App\Ship\Parents\Traits\ValidationExtendTrait;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Sentry\Event;
use function Sentry\captureMessage;

class ShipProvider extends MainProvider
{
    use ValidationExtendTrait;

    /**
     * Register any Service Providers on the Ship layer (including third party packages).
     */
    public array $serviceProviders = [
        RoutesProvider::class,
    ];

    /**
     * Register any Alias on the Ship layer (including third party packages).
     */
    protected array $aliases = [];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();
        if (env('APP_KEY') === null) {
            Artisan::call('optimize:clear');
            Event::createEvent(captureMessage('Env return null value'));
        }
        // Registering custom rule and validation rules
        $this->extendValidationRules();
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        /**
         * Load the ide-helper service provider only in non production environments.
         */
        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        parent::register();
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Providers;

use App\Containers\AppSection\Yodlee\UI\CLI\Commands\YodleeImport;
use App\Ship\Parents\Providers\MainProvider;
use Illuminate\Console\Scheduling\Schedule;

/**
 * The Main Service Provider of this container, it will be automatically registered in the framework.
 */
class MainServiceProvider extends MainProvider
{
    public array $serviceProviders = [
        // InternalServiceProviderExample::class,
        EventServiceProvider::class,
    ];

    public array $aliases = [
        // 'Foo' => Bar::class,
    ];

    public function register(): void
    {
        parent::register();

        // $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        // ...make f
    }

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(YodleeImport::class)->everyTenMinutes();
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Providers;

use App\Containers\AppSection\Salesforce\UI\CLI\Commands\SalesforceExport;
use App\Containers\AppSection\Salesforce\UI\CLI\Commands\SalesforceImport;
use App\Ship\Parents\Providers\MainProvider;
use Illuminate\Console\Scheduling\Schedule;

/**
 * The Main Service Provider of this container, it will be automatically registered in the framework.
 */
class MainServiceProvider extends MainProvider
{
    public array $serviceProviders = [
        EventServiceProvider::class,
    ];

    public array $aliases = [
        // 'Foo' => Bar::class,
    ];

    public function register(): void
    {
        parent::register();

        // $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        // ...
    }

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(SalesforceImport::class)->everyMinute();
        $schedule->command(SalesforceExport::class)->everyMinute();
    }
}

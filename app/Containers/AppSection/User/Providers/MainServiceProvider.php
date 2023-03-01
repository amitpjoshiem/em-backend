<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Providers;

use App\Containers\AppSection\User\Contracts\UserRepositoryInterface;
use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Helper\UserHelper;
use App\Containers\AppSection\User\UI\CLI\Commands\UserPhoneExpireCommand;
use App\Ship\Parents\Providers\MainProvider;
use Illuminate\Console\Scheduling\Schedule;

class MainServiceProvider extends MainProvider
{
    /**
     * Container Service Providers.
     */
    public array $serviceProviders = [
        EventServiceProvider::class,
        MiddlewareServiceProvider::class,
    ];

    /**
     * Register anything in the container.
     */
    public function register(): void
    {
        parent::register();

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(UserHelper::class, function (): UserHelper {
            return UserHelper::instance();
        });
    }

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(UserPhoneExpireCommand::class)->daily();
    }
}

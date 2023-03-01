<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Providers;

use App\Containers\AppSection\Authentication\Data\Repositories\CacheClientRepository;
use App\Containers\AppSection\Authentication\Events\Observers\PassportClientObserver;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;

class CacheClientServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Client::observe(PassportClientObserver::class);
    }

    public function register(): void
    {
        $this->app->singleton(ClientRepository::class, CacheClientRepository::class);
    }
}

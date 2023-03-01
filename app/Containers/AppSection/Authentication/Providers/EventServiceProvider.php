<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Providers;

use App\Containers\AppSection\User\Events\Handlers\LogSuccessfulLogin;
use App\Ship\Parents\Providers\EventsProvider;
use Laravel\Passport\Events\AccessTokenCreated;

class EventServiceProvider extends EventsProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AccessTokenCreated::class => [
            LogSuccessfulLogin::class,
        ],
    ];
}

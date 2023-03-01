<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Providers;

use App\Containers\AppSection\Authentication\Events\ApiLoginEvent;
use App\Containers\AppSection\Authentication\Events\ApiLogoutEvent;
use App\Containers\AppSection\Otp\Events\Handlers\CheckLogoutEventHandler;
use App\Containers\AppSection\Otp\Events\Handlers\CheckOtpEventHandler;
use App\Ship\Parents\Providers\EventsProvider;

class EventServiceProvider extends EventsProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ApiLoginEvent::class => [
            CheckOtpEventHandler::class,
        ],
        ApiLogoutEvent::class => [
            CheckLogoutEventHandler::class,
        ],
    ];
}

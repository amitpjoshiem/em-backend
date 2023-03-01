<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Providers;

use App\Containers\AppSection\User\Events\Events\PhoneExpiredEvent;
use App\Containers\AppSection\User\Events\Events\PhoneExpiredWarningEvent;
use App\Containers\AppSection\User\Events\Handlers\PhoneExpireEventHandler;
use App\Containers\AppSection\User\Events\Handlers\PhoneExpireWarningEventHandler;
use App\Containers\AppSection\User\Events\Handlers\PhoneExpireWarningNotificationEventHandler;
use App\Containers\AppSection\User\Events\Handlers\UserRegistered;
use App\Ship\Parents\Providers\EventsProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use LaravelCentrifugo\Events\SubscribeEvent;

class EventServiceProvider extends EventsProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            UserRegistered::class,
            SendEmailVerificationNotification::class,
        ],
        PhoneExpiredWarningEvent::class => [
            PhoneExpireWarningEventHandler::class,
        ],
        PhoneExpiredEvent::class => [
            PhoneExpireEventHandler::class,
        ],
        SubscribeEvent::class => [
            PhoneExpireWarningNotificationEventHandler::class,
        ],
    ];
}

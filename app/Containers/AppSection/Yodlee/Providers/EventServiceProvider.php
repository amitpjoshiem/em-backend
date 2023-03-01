<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Providers;

use App\Containers\AppSection\Yodlee\Events\Events\CreateYodleeMemberEvent;
use App\Containers\AppSection\Yodlee\Events\Handlers\CheckYodleeMemberCreatedEventHandler;
use App\Ship\Parents\Providers\EventsProvider;

class EventServiceProvider extends EventsProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CreateYodleeMemberEvent::class => [
            CheckYodleeMemberCreatedEventHandler::class,
        ],
    ];
}

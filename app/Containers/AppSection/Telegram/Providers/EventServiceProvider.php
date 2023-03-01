<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Telegram\Providers;

use App\Containers\AppSection\Telegram\Events\Handlers\InputMessageEventHandler;
use App\Ship\Parents\Providers\EventsProvider;
use Zavrik\LaravelTelegram\Events\InputMessageEvent;

class EventServiceProvider extends EventsProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        InputMessageEvent::class => [
            InputMessageEventHandler::class,
        ],
    ];
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Providers;

use App\Containers\AppSection\ClientReport\Events\Events\GenerateExcelEvent;
use App\Containers\AppSection\ClientReport\Events\Events\GeneratePdfEvent;
use App\Containers\AppSection\ClientReport\Events\Events\ShareDocEvent;
use App\Containers\AppSection\ClientReport\Events\Handlers\GenerateExcelEventHandler;
use App\Containers\AppSection\ClientReport\Events\Handlers\GeneratePdfEventHandler;
use App\Containers\AppSection\ClientReport\Events\Handlers\ShareDocEventHandler;
use App\Ship\Parents\Providers\EventsProvider;

class EventServiceProvider extends EventsProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ShareDocEvent::class => [
            ShareDocEventHandler::class,
        ],
        GeneratePdfEvent::class => [
            GeneratePdfEventHandler::class,
        ],
        GenerateExcelEvent::class => [
            GenerateExcelEventHandler::class,
        ],
    ];
}

<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Providers;

use App\Containers\AppSection\AssetsConsolidations\Events\Events\GenerateExcelExportEvent;
use App\Containers\AppSection\AssetsConsolidations\Events\Handlers\GenerateExcelExportEventHandler;
use App\Ship\Parents\Providers\EventsProvider;

class EventServiceProvider extends EventsProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        GenerateExcelExportEvent::class => [
            GenerateExcelExportEventHandler::class,
        ],
    ];
}

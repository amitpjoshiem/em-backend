<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Providers;

use App\Containers\AppSection\Member\Events\Events\ProspectConvertToClientEvent;
use App\Containers\AppSection\Member\Events\Events\ShareMemberReportEvent;
use App\Containers\AppSection\Member\Events\Handlers\CheckShareMemberReportEventHandler;
use App\Containers\AppSection\Member\Events\Handlers\ProspectConvertToClientEventHandler;
use App\Ship\Parents\Providers\EventsProvider;

class EventServiceProvider extends EventsProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ShareMemberReportEvent::class => [
            CheckShareMemberReportEventHandler::class,
        ],
        ProspectConvertToClientEvent::class => [
            ProspectConvertToClientEventHandler::class,
        ],
    ];
}

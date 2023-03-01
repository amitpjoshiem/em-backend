<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Providers;

use App\Containers\AppSection\Authentication\Events\ApiLoginEvent;
use App\Containers\AppSection\Client\Events\Events\SubmitClientEvent;
use App\Containers\AppSection\Client\Events\Handlers\CheckClientFirstFillInfoEventHandler;
use App\Containers\AppSection\Client\Events\Handlers\ConvertFromLeadEventHandler;
use App\Containers\AppSection\Client\Events\Handlers\SubmitClientEventHandler;
use App\Containers\AppSection\Client\Events\Handlers\UpdateSalesforceOpportunityEventHandler;
use App\Containers\AppSection\Member\Events\Events\ConvertFromLeadMemberEvent;
use App\Containers\AppSection\Salesforce\Events\Events\SalesforceUpdateOpportunityEvent;
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
            CheckClientFirstFillInfoEventHandler::class,
        ],
        SalesforceUpdateOpportunityEvent::class => [
            UpdateSalesforceOpportunityEventHandler::class,
        ],
        ConvertFromLeadMemberEvent::class => [
            ConvertFromLeadEventHandler::class,
        ],
        SubmitClientEvent::class => [
            SubmitClientEventHandler::class,
        ]
    ];
}

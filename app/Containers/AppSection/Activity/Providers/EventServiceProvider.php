<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\Providers;

use App\Containers\AppSection\Activity\Events\Events\ChangeOTPServiceEvent;
use App\Containers\AppSection\Activity\Events\Events\ChangeOwnEmailEvent;
use App\Containers\AppSection\Activity\Events\Events\ClientAccountDeactivatedEvent;
use App\Containers\AppSection\Activity\Events\Events\ImportMemberFromSalesforceEvent;
use App\Containers\AppSection\Activity\Events\Events\LeadAddedEvent;
use App\Containers\AppSection\Activity\Events\Events\LeadConvertToProspectEvent;
use App\Containers\AppSection\Activity\Events\Events\MemberChildOpportunityAddedEvent;
use App\Containers\AppSection\Activity\Events\Events\MemberUpdateBasicInfoEvent;
use App\Containers\AppSection\Activity\Events\Events\ProspectAddedEvent;
use App\Containers\AppSection\Activity\Events\Events\ProspectConvertToClientEvent;
use App\Containers\AppSection\Activity\Events\Events\SharedPDFToEvent;
use App\Containers\AppSection\Activity\Events\Handlers\ActivityEventHandler;
use App\Ship\Parents\Providers\EventsProvider;

class EventServiceProvider extends EventsProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ProspectAddedEvent::class => [
            ActivityEventHandler::class,
        ],
        ChangeOwnEmailEvent::class => [
            ActivityEventHandler::class,
        ],
        ChangeOTPServiceEvent::class => [
            ActivityEventHandler::class,
        ],
        SharedPDFToEvent::class => [
            ActivityEventHandler::class,
        ],
        MemberChildOpportunityAddedEvent::class => [
            ActivityEventHandler::class,
        ],
        ProspectConvertToClientEvent::class => [
            ActivityEventHandler::class,
        ],
        ImportMemberFromSalesforceEvent::class => [
            ActivityEventHandler::class,
        ],
        MemberUpdateBasicInfoEvent::class => [
            ActivityEventHandler::class,
        ],
        LeadConvertToProspectEvent::class => [
            ActivityEventHandler::class,
        ],
        LeadAddedEvent::class => [
            ActivityEventHandler::class,
        ],
        ClientAccountDeactivatedEvent::class => [
            ActivityEventHandler::class,
        ],
    ];
}

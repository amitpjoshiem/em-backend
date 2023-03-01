<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Providers;

use App\Containers\AppSection\Media\Events\Events\AttachMediaFromTemporaryUploadEvent;
use App\Containers\AppSection\Member\Events\Events\CreateContactEvent;
use App\Containers\AppSection\Member\Events\Events\CreateMemberEvent;
use App\Containers\AppSection\Member\Events\Events\DeleteContactEvent;
use App\Containers\AppSection\Member\Events\Events\DeleteMemberEvent;
use App\Containers\AppSection\Member\Events\Events\UpdateContactEvent;
use App\Containers\AppSection\Member\Events\Events\UpdateMemberEvent;
use App\Containers\AppSection\Salesforce\Events\Events\SalesforceCreateChildOpportunityEvent;
use App\Containers\AppSection\Salesforce\Events\Events\SalesforceUpdateChildOpportunityEvent;
use App\Containers\AppSection\Salesforce\Events\Events\SalesforceUserLoginEvent;
use App\Containers\AppSection\Salesforce\Events\Handlers\CheckMemberCreateEventHandler;
use App\Containers\AppSection\Salesforce\Events\Handlers\CheckMemberDeleteEventHandler;
use App\Containers\AppSection\Salesforce\Events\Handlers\CheckMemberUpdateEventHandler;
use App\Containers\AppSection\Salesforce\Events\Handlers\CreateMemberContactEventHandler;
use App\Containers\AppSection\Salesforce\Events\Handlers\DeleteMemberContactEventHandler;
use App\Containers\AppSection\Salesforce\Events\Handlers\SalesforceCreateChildOpportunityEventHandler;
use App\Containers\AppSection\Salesforce\Events\Handlers\SalesforceUpdateChildOpportunityEventHandler;
use App\Containers\AppSection\Salesforce\Events\Handlers\SalesforceUserLoginEventHandler;
use App\Containers\AppSection\Salesforce\Events\Handlers\UpdateMemberContactEventHandler;
use App\Containers\AppSection\Salesforce\Events\Handlers\UploadClientDocsEventHandler;
use App\Ship\Parents\Providers\EventsProvider;

class EventServiceProvider extends EventsProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CreateMemberEvent::class => [
            CheckMemberCreateEventHandler::class,
        ],
        UpdateMemberEvent::class => [
            CheckMemberUpdateEventHandler::class,
        ],
        DeleteMemberEvent::class => [
            CheckMemberDeleteEventHandler::class,
        ],
        SalesforceUserLoginEvent::class => [
            SalesforceUserLoginEventHandler::class,
        ],
        CreateContactEvent::class => [
            CreateMemberContactEventHandler::class,
        ],
        UpdateContactEvent::class => [
            UpdateMemberContactEventHandler::class,
        ],
        DeleteContactEvent::class => [
            DeleteMemberContactEventHandler::class,
        ],
        SalesforceUpdateChildOpportunityEvent::class => [
            SalesforceUpdateChildOpportunityEventHandler::class,
        ],
        SalesforceCreateChildOpportunityEvent::class => [
            SalesforceCreateChildOpportunityEventHandler::class,
        ],
        AttachMediaFromTemporaryUploadEvent::class => [
            UploadClientDocsEventHandler::class,
        ],
    ];
}

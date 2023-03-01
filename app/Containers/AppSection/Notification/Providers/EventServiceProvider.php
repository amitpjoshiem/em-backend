<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Notification\Providers;

use App\Containers\AppSection\Notification\Events\Events\BlueprintDocGeneratedEvent;
use App\Containers\AppSection\Notification\Events\Events\ClientReportDocGeneratedEvent;
use App\Containers\AppSection\Notification\Events\Events\ClientSubmitEvent;
use App\Containers\AppSection\Notification\Events\Events\DocusignEnvelopCompleteEvent;
use App\Containers\AppSection\Notification\Events\Events\DocusignUserSignedEvent;
use App\Containers\AppSection\Notification\Events\Events\ExcelExportFinishedNotificationEvent;
use App\Containers\AppSection\Notification\Events\Events\PhoneWarningNotificationEvent;
use App\Containers\AppSection\Notification\Events\Events\SalesforceImportAccountNotificationEvent;
use App\Containers\AppSection\Notification\Events\Events\SalesforceImportChildOpportunityNotificationEvent;
use App\Containers\AppSection\Notification\Events\Events\TestNotificationEvent;
use App\Containers\AppSection\Notification\Events\Events\UserDeletingNotificationEvent;
use App\Containers\AppSection\Notification\Events\Events\UserRestoredNotificationEvent;
use App\Containers\AppSection\Notification\Events\Handlers\NotificationEventHandler;
use App\Ship\Parents\Providers\EventsProvider;

class EventServiceProvider extends EventsProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        TestNotificationEvent::class => [
            NotificationEventHandler::class,
        ],
        SalesforceImportAccountNotificationEvent::class => [
            NotificationEventHandler::class,
        ],
        SalesforceImportChildOpportunityNotificationEvent::class => [
            NotificationEventHandler::class,
        ],
        ExcelExportFinishedNotificationEvent::class => [
            NotificationEventHandler::class,
        ],
        BlueprintDocGeneratedEvent::class => [
            NotificationEventHandler::class,
        ],
        ClientReportDocGeneratedEvent::class => [
            NotificationEventHandler::class,
        ],
        PhoneWarningNotificationEvent::class => [
            NotificationEventHandler::class,
        ],
        UserDeletingNotificationEvent::class => [
            NotificationEventHandler::class,
        ],
        UserRestoredNotificationEvent::class => [
            NotificationEventHandler::class,
        ],
        ClientSubmitEvent::class => [
            NotificationEventHandler::class,
        ],
        DocusignUserSignedEvent::class => [
            NotificationEventHandler::class,
        ],
        DocusignEnvelopCompleteEvent::class => [
            NotificationEventHandler::class,
        ],
    ];
}

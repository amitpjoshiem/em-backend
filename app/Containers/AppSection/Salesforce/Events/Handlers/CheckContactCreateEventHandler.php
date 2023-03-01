<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Events\Handlers;

use App\Containers\AppSection\Member\Events\Events\CreateContactEvent;
use App\Containers\AppSection\Salesforce\Actions\Contact\CreateContactAction;
use App\Containers\AppSection\Salesforce\Data\Transporters\ContactTransporters\CreateSalesforceContactTransporter;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckContactCreateEventHandler implements ShouldQueue
{
    public function handle(CreateContactEvent $event): void
    {
        app(CreateContactAction::class)->run(new CreateSalesforceContactTransporter([
            'contact_id' => $event->entity->getKey(),
        ]));
    }
}

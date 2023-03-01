<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Events\Handlers;

use App\Containers\AppSection\Member\Events\Events\UpdateContactEvent;
use App\Containers\AppSection\Salesforce\Actions\Contact\UpdateContactAction;
use App\Containers\AppSection\Salesforce\Data\Transporters\ContactTransporters\UpdateSalesforceContactTransporter;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckContactUpdateEventHandler implements ShouldQueue
{
    public function handle(UpdateContactEvent $event): void
    {
        app(UpdateContactAction::class)->run(new UpdateSalesforceContactTransporter([
            'contact_id' => $event->entity->getKey(),
        ]));
    }
}

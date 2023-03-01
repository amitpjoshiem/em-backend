<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Events\Handlers;

use App\Containers\AppSection\Member\Events\Events\UpdateContactEvent;
use App\Containers\AppSection\Salesforce\Actions\Contact\UpdateContactAction;
use App\Containers\AppSection\Salesforce\Data\Transporters\ContactTransporters\UpdateSalesforceContactTransporter;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateMemberContactEventHandler implements ShouldQueue
{
    public function handle(UpdateContactEvent $event): void
    {
        $data = new UpdateSalesforceContactTransporter([
            'contact_id'    => $event->entity->getKey(),
        ]);

        app(UpdateContactAction::class)->run($data);
    }
}

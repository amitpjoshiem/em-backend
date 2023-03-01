<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Events\Handlers;

use App\Containers\AppSection\Member\Events\Events\CreateContactEvent;
use App\Containers\AppSection\Salesforce\Actions\Contact\CreateContactAction;
use App\Containers\AppSection\Salesforce\Data\Transporters\ContactTransporters\CreateSalesforceContactTransporter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateMemberContactEventHandler implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(CreateContactEvent $event): void
    {
        $data = new CreateSalesforceContactTransporter([
            'contact_id' => $event->entity->getKey(),
        ]);

        app(CreateContactAction::class)->run($data);
    }
}

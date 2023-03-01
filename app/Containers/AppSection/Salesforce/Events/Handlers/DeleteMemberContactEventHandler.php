<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Events\Handlers;

use App\Containers\AppSection\Member\Events\Events\DeleteContactEvent;
use App\Containers\AppSection\Salesforce\Actions\Contact\DeleteContactAction;
use App\Containers\AppSection\Salesforce\Data\Transporters\ContactTransporters\DeleteSalesforceContactTransporter;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteMemberContactEventHandler implements ShouldQueue
{
    public function handle(DeleteContactEvent $event): void
    {
        $data = new DeleteSalesforceContactTransporter([
            'contact_id' => $event->id,
        ]);

        app(DeleteContactAction::class)->run($data);
    }
}

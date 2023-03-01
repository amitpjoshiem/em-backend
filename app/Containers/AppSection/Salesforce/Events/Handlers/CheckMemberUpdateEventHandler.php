<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Events\Handlers;

use App\Containers\AppSection\Member\Events\Events\UpdateMemberEvent;
use App\Containers\AppSection\Salesforce\Actions\Account\UpdateAccountAction;
use App\Containers\AppSection\Salesforce\Actions\Contact\UpdateContactAction;
use App\Containers\AppSection\Salesforce\Data\Transporters\AccountTransporters\UpdateSalesforceAccountTransporter;
use App\Containers\AppSection\Salesforce\Data\Transporters\ContactTransporters\UpdateSalesforceContactTransporter;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckMemberUpdateEventHandler implements ShouldQueue
{
    public function handle(UpdateMemberEvent $event): void
    {
        $input = new UpdateSalesforceAccountTransporter([
            'member_id' => $event->entity->getKey(),
        ]);
        app(UpdateAccountAction::class)->run($input);

        if ($event->entity->married) {
            $input = new UpdateSalesforceContactTransporter([
                'contact_id' => $event->entity->spouse->getKey(),
            ]);
            app(UpdateContactAction::class)->run($input);
        }
    }
}
